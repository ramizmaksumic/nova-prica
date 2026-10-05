<?php

use App\Mail\EventReminderMail;
use App\Models\Event;
use App\Models\NewsletterContact;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('public pages render with unique title, description and canonical', function (string $route, string $title) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee("<title>{$title}", false)
        ->assertSee('<meta name="description"', false)
        ->assertSee('<link rel="canonical"', false)
        ->assertSee('<html lang="bs">', false);
})->with([
    ['home', 'Nova'],
    ['events', 'Događaji i rezervacija stolova'],
    ['menu', 'Meni'],
    ['contact', 'Kontakt'],
    ['about-us', 'O nama'],
]);

test('auth pages are marked noindex', function () {
    $this->get(route('login'))->assertOk()->assertSee('noindex', false);
});

test('sitemap lists public pages and active events only', function () {
    $active = Event::create(['name' => 'A', 'date' => now()->addDay(), 'status' => 'active']);
    $inactive = Event::create(['name' => 'B', 'date' => now()->addDay(), 'status' => 'inactive']);

    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee(route('event.detail', $active), false)
        ->assertDontSee(route('event.detail', $inactive), false)
        ->assertSee(route('menu'), false);
});

test('old misspelled urls redirect permanently', function () {
    $this->get('/kontatk')->assertStatus(301)->assertRedirect('/kontakt');
    $this->get('/o-namam')->assertStatus(301)->assertRedirect('/o-nama');
});

test('www host redirects to canonical host in production', function () {
    config(['app.url' => 'https://novaprica.ba']);
    $this->app['env'] = 'production';

    $this->get('https://www.novaprica.ba/events?x=1')
        ->assertStatus(301)
        ->assertRedirect('https://novaprica.ba/events?x=1');
});

test('newsletter validates email and ignores duplicates', function () {
    $this->post(route('newsletter.store'), ['email' => 'nije-email'])->assertSessionHasErrors('email');
    $this->post(route('newsletter.store'), ['email' => 'Gost@Mail.ba']);
    $this->post(route('newsletter.store'), ['email' => 'gost@mail.ba']);

    expect(NewsletterContact::count())->toBe(1);
});

test('reminder command mails only confirmed reservations once', function () {
    Mail::fake();
    $event = Event::create(['name' => 'Danas', 'date' => now()->setTime(22, 0), 'status' => 'active']);
    $table1 = Table::create(['name' => 'S1', 'description' => '']);
    $table2 = Table::create(['name' => 'S2', 'description' => '']);
    $confirmed = User::factory()->create();
    $pending = User::factory()->create();
    Reservation::create(['event_id' => $event->id, 'table_id' => $table1->id, 'user_id' => $confirmed->id, 'num_people' => 2, 'status' => 'active']);
    Reservation::create(['event_id' => $event->id, 'table_id' => $table2->id, 'user_id' => $pending->id, 'num_people' => 2, 'status' => 'pending']);

    $this->artisan('events:send-reminders')->assertSuccessful();
    $this->artisan('events:send-reminders')->assertSuccessful();

    Mail::assertQueued(EventReminderMail::class, 1);
    Mail::assertQueued(EventReminderMail::class, fn ($mail) => $mail->hasTo($confirmed->email));
    expect($event->fresh()->reminder_sent)->toBeTrue();
});

test('reservation mails render', function () {
    $event = Event::create(['name' => 'Event', 'date' => now()->addDay(), 'status' => 'active']);
    $table = Table::create(['name' => 'S1', 'description' => '']);
    $reservation = Reservation::create(['event_id' => $event->id, 'table_id' => $table->id, 'user_id' => User::factory()->create()->id, 'num_people' => 2, 'status' => 'active']);

    expect((new \App\Mail\ReservationConfirmedMail($reservation))->render())->toContain('S1')
        ->and((new \App\Mail\ReservationUpdateMail($reservation))->render())->toContain('Potvrđena')
        ->and((new \App\Mail\ReservationDeleteMail($reservation))->render())->toContain('otkazana')
        ->and((new EventReminderMail($reservation))->render())->toContain('Event');
});
