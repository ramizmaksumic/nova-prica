<?php

use App\Mail\ReservationConfirmedMail;
use App\Mail\ReservationUpdateMail;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Mail;

function makeEvent(array $attributes = []): Event
{
    return Event::create($attributes + [
        'name' => 'Subota party',
        'description' => 'Opis',
        'price' => 10,
        'date' => now()->addDays(3)->setTime(22, 0),
        'status' => 'active',
    ]);
}

function makeTable(array $attributes = []): Table
{
    return Table::create($attributes + [
        'name' => 'S' . fake()->unique()->numberBetween(1, 9999),
        'min_capacity' => 2,
        'max_capacity' => 6,
        'description' => '',
    ]);
}

function reserve(User $user, Event $event, Table $table, int $people = 2)
{
    return test()->actingAs($user)
        ->from(route('event.detail', $event))
        ->post(route('reservations.store'), [
            'event_id' => $event->id,
            'table_id' => $table->id,
            'num_people' => $people,
            'notes' => null,
        ]);
}

beforeEach(fn () => Mail::fake());

test('user can reserve a free table and confirmation mail is queued', function () {
    $user = User::factory()->create();
    $event = makeEvent();
    $table = makeTable();

    reserve($user, $event, $table)->assertSessionHasNoErrors()->assertRedirect();

    expect(Reservation::where('user_id', $user->id)->where('table_id', $table->id)->first()->status)
        ->toBe(Reservation::STATUS_PENDING);
    Mail::assertQueued(ReservationConfirmedMail::class, fn ($mail) => $mail->hasTo($user->email));
});

test('table cannot be reserved twice for the same event', function () {
    $event = makeEvent();
    $table = makeTable();

    reserve(User::factory()->create(), $event, $table)->assertSessionHasNoErrors();
    reserve(User::factory()->create(), $event, $table)->assertSessionHasErrors('table_id');

    expect(Reservation::where('event_id', $event->id)->count())->toBe(1);
});

test('database rejects a second active reservation even if application check is bypassed', function () {
    $event = makeEvent();
    $table = makeTable();
    $data = ['event_id' => $event->id, 'table_id' => $table->id, 'num_people' => 2, 'status' => 'pending'];

    Reservation::create($data + ['user_id' => User::factory()->create()->id]);

    expect(fn () => Reservation::create($data + ['user_id' => User::factory()->create()->id]))
        ->toThrow(UniqueConstraintViolationException::class);
});

test('cancelled reservation frees the table', function () {
    $event = makeEvent();
    $table = makeTable();
    $first = User::factory()->create();

    reserve($first, $event, $table);
    $reservation = Reservation::where('user_id', $first->id)->first();

    $this->actingAs($first)->delete(route('reservations.destroy', $reservation))->assertRedirect();
    expect($reservation->fresh()->status)->toBe(Reservation::STATUS_CANCELLED);
    Mail::assertQueued(ReservationUpdateMail::class);

    reserve(User::factory()->create(), $event, $table)->assertSessionHasNoErrors();
});

test('same table can be reserved for different events', function () {
    $table = makeTable();

    reserve(User::factory()->create(), makeEvent(), $table)->assertSessionHasNoErrors();
    reserve(User::factory()->create(), makeEvent(['date' => now()->addDays(4)]), $table)->assertSessionHasNoErrors();

    expect(Reservation::count())->toBe(2);
});

test('number of people must fit table capacity', function () {
    $user = User::factory()->create();
    $event = makeEvent();
    $table = makeTable(['min_capacity' => 2, 'max_capacity' => 4]);

    reserve($user, $event, $table, 8)->assertSessionHasErrors('num_people');
    reserve($user, $event, $table, 1)->assertSessionHasErrors('num_people');

    expect(Reservation::count())->toBe(0);
});

test('user can have only one active reservation per event', function () {
    $user = User::factory()->create();
    $event = makeEvent();

    reserve($user, $event, makeTable())->assertSessionHasNoErrors();
    reserve($user, $event, makeTable())->assertSessionHasErrors('table_id');

    expect(Reservation::count())->toBe(1);
});

test('reservations are rejected for inactive, ended and Entrio events', function (array $eventAttributes) {
    reserve(User::factory()->create(), makeEvent($eventAttributes), makeTable())
        ->assertSessionHasErrors('event_id');

    expect(Reservation::count())->toBe(0);
})->with([
    'inactive' => [['status' => 'inactive']],
    'ended' => [['date' => now()->subDays(2)]],
    'entrio' => [['link' => 'https://www.entrio.hr/event/test']],
]);

test('date-only event stays open for reservations until next morning', function () {
    $this->travelTo(now()->startOfDay()->setTime(21, 0));
    $event = makeEvent(['date' => now()->startOfDay()]); // spremljeno samo s datumom (00:00)

    expect($event->hasEnded())->toBeFalse();
    reserve(User::factory()->create(), $event, makeTable())->assertSessionHasNoErrors();

    $this->travelTo(now()->addDay()->setTime(7, 0));
    expect($event->fresh()->hasEnded())->toBeTrue();
});

test('user cannot edit, update or cancel someone else\'s reservation', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    reserve($owner, makeEvent(), makeTable());
    $reservation = Reservation::first();

    $this->actingAs($other)->get(route('reservations.edit', $reservation))->assertForbidden();
    $this->actingAs($other)->put(route('reservations.update', $reservation), ['num_people' => 3])->assertForbidden();
    $this->actingAs($other)->delete(route('reservations.destroy', $reservation))->assertForbidden();

    expect($reservation->fresh()->status)->toBe(Reservation::STATUS_PENDING);
});

test('owner can update own reservation within table capacity', function () {
    $owner = User::factory()->create();
    reserve($owner, makeEvent(), makeTable(['max_capacity' => 4]));
    $reservation = Reservation::first();

    $this->actingAs($owner)->put(route('reservations.update', $reservation), ['num_people' => 9])
        ->assertSessionHasErrors('num_people');
    $this->actingAs($owner)->put(route('reservations.update', $reservation), ['num_people' => 4, 'notes' => 'Rođendan'])
        ->assertRedirect(route('profile.index'));

    expect($reservation->fresh()->num_people)->toBe(4);
});

test('event detail page shows map, hides inactive events from public', function () {
    $active = makeEvent();
    $inactive = makeEvent(['status' => 'inactive']);
    makeTable();

    $this->get(route('event.detail', $active))->assertOk()->assertSee('application/ld+json', false);
    $this->get(route('event.detail', $inactive))->assertNotFound();

    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $this->actingAs($admin)->get(route('event.detail', $inactive))->assertOk();
});

test('events page lists only upcoming active events', function () {
    makeEvent(['name' => 'Buduci dogadjaj']);
    makeEvent(['name' => 'Prosli dogadjaj', 'date' => now()->subWeek()]);
    makeEvent(['name' => 'Skriveni dogadjaj', 'status' => 'inactive']);

    $this->get(route('events'))
        ->assertOk()
        ->assertSee('Buduci dogadjaj')
        ->assertDontSee('Prosli dogadjaj')
        ->assertDontSee('Skriveni dogadjaj');
});

test('profile page lists own reservations for admin and user', function () {
    $user = User::factory()->create();
    reserve($user, makeEvent(['name' => 'Moj event']), makeTable());

    $this->actingAs($user)->get(route('profile.index'))->assertOk()->assertSee('Moj event')->assertSee('Na čekanju');

    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $this->actingAs($admin)->get(route('profile.index'))->assertOk();
});
