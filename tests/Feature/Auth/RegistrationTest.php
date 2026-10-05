<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register and must verify email before logging in', function () {
    $response = $this->post('/register', [
        'name' => 'Test',
        'surname' => 'User',
        'email' => 'test@example.com',
        'phone' => '061123456',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // Korisnik se ne prijavljuje automatski; prvo mora potvrditi email.
    $this->assertGuest();
    $response->assertRedirect(route('verification.notice', absolute: false));
    expect(User::where('email', 'test@example.com')->first())
        ->not->toBeNull()
        ->role->toBe('user');
});
