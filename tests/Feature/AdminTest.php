<?php

use App\Livewire\Admin\ReservationCreate;
use App\Livewire\Admin\Reservations;
use App\Livewire\Admin\ReservationUpdate;
use App\Livewire\Admin\TableDelete;
use App\Livewire\Admin\UserUpdate;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

function admin(): User
{
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();

    return $admin;
}

function adminEvent(): Event
{
    return Event::create(['name' => 'Event', 'date' => now()->addDays(2), 'status' => 'active']);
}

function adminTable(string $name = 'S1'): Table
{
    return Table::create(['name' => $name, 'min_capacity' => 2, 'max_capacity' => 6, 'description' => '']);
}

beforeEach(fn () => Mail::fake());

test('admin pages and components are forbidden for regular users and guests', function () {
    $user = User::factory()->create();

    $this->get(route('admin.reservations'))->assertRedirect(route('login'));
    $this->actingAs($user)->get(route('admin.reservations'))->assertForbidden();

    // Direktan Livewire poziv admin komponente (zaobilazi rutu) mora biti odbijen.
    Livewire::actingAs($user)->test(UserUpdate::class, ['userId' => $user->id])->assertForbidden();
    Livewire::actingAs($user)->test(Reservations::class)->assertForbidden();
});

test('admin dashboard routes render', function () {
    $admin = admin();

    foreach (['admin.dashboard', 'admin.events', 'admin.reservations', 'admin.tables', 'admin.posts', 'admin.menus', 'admin.contacts', 'admin.users'] as $route) {
        $this->actingAs($admin)->get(route($route))->assertOk();
    }
    $this->actingAs($admin)->get('/admin')->assertRedirect('/admin/dashboard');
});

test('admin can create phone reservation for guest without account', function () {
    $event = adminEvent();
    $table = adminTable();

    Livewire::actingAs(admin())->test(ReservationCreate::class)
        ->set('event_id', $event->id)
        ->set('table_id', $table->id)
        ->set('guest_name', 'Marko Marić')
        ->set('guest_phone', '061 222 333')
        ->set('num_people', 4)
        ->call('save')
        ->assertHasNoErrors();

    $reservation = Reservation::first();
    expect($reservation->user_id)->toBeNull()
        ->and($reservation->guestDisplayName())->toBe('Marko Marić')
        ->and($reservation->status)->toBe(Reservation::STATUS_ACTIVE);

    $this->actingAs(admin())->get(route('admin.reservations'))->assertOk()->assertSee('Marko Marić');
});

test('admin cannot double book a table', function () {
    $event = adminEvent();
    $table = adminTable();
    Reservation::create(['event_id' => $event->id, 'table_id' => $table->id, 'user_id' => User::factory()->create()->id, 'num_people' => 2, 'status' => 'pending']);

    Livewire::actingAs(admin())->test(ReservationCreate::class)
        ->set('event_id', $event->id)
        ->set('table_id', $table->id)
        ->set('guest_name', 'Gost')
        ->set('num_people', 2)
        ->call('save')
        ->assertHasErrors('table_id');

    expect(Reservation::count())->toBe(1);
});

test('admin moving reservation to a taken table is rejected', function () {
    $event = adminEvent();
    $t1 = adminTable('S1');
    $t2 = adminTable('S2');
    $base = ['event_id' => $event->id, 'num_people' => 2, 'status' => 'pending'];
    Reservation::create($base + ['table_id' => $t1->id, 'user_id' => User::factory()->create()->id]);
    $second = Reservation::create($base + ['table_id' => $t2->id, 'user_id' => User::factory()->create()->id]);

    Livewire::actingAs(admin())->test(ReservationUpdate::class, ['reservationId' => $second->id])
        ->set('table', $t1->id)
        ->call('update')
        ->assertHasErrors('table_id');

    expect($second->fresh()->table_id)->toBe($t2->id);
});

test('admin confirming reservation queues mail to the guest', function () {
    $user = User::factory()->create();
    $reservation = Reservation::create(['event_id' => adminEvent()->id, 'table_id' => adminTable()->id, 'user_id' => $user->id, 'num_people' => 2, 'status' => 'pending']);

    Livewire::actingAs(admin())->test(ReservationUpdate::class, ['reservationId' => $reservation->id])
        ->set('status', 'active')
        ->call('update')
        ->assertHasNoErrors();

    expect($reservation->fresh()->status)->toBe('active');
    Mail::assertQueued(\App\Mail\ReservationUpdateMail::class, fn ($mail) => $mail->hasTo($user->email));
});

test('table with upcoming reservations cannot be deleted', function () {
    $table = adminTable();
    Reservation::create(['event_id' => adminEvent()->id, 'table_id' => $table->id, 'user_id' => User::factory()->create()->id, 'num_people' => 2, 'status' => 'active']);

    Livewire::actingAs(admin())->test(TableDelete::class, ['tableId' => $table->id])
        ->call('deleteTable')
        ->assertSet('blockedReason', fn ($reason) => $reason !== null);

    expect(Table::find($table->id))->not->toBeNull();
});

test('admin can promote user to admin but cannot demote self', function () {
    $admin = admin();
    $user = User::factory()->create();

    Livewire::actingAs($admin)->test(UserUpdate::class, ['userId' => $user->id])
        ->set('role', 'admin')
        ->call('update')
        ->assertHasNoErrors();
    expect($user->fresh()->isAdmin())->toBeTrue();

    Livewire::actingAs($admin)->test(UserUpdate::class, ['userId' => $admin->id])
        ->set('role', 'user')
        ->call('update')
        ->assertHasErrors('role');
    expect($admin->fresh()->isAdmin())->toBeTrue();
});

test('role cannot be mass assigned', function () {
    $user = User::create(['name' => 'X', 'email' => 'x@x.ba', 'password' => 'secret123', 'role' => 'admin']);

    expect($user->fresh()->role)->toBe('user');
});
