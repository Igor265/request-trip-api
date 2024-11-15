<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('should be able to login', function () {

    User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);

    $this->post('/api/login', [
        'email' => 'joe@doe.com',
        'password' => 'password'
    ]);

    $this->assertAuthenticated();
});

it('should not be able to login with a wrong password', function () {

    User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);

    $this->post('/api/login', [
        'email' => 'joe@doe.com',
        'password' => 'password2'
    ]);

    $this->assertGuest();
});

it('should invalidate the token on logout', function () {
    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);

    $token = $user->createToken('token')->plainTextToken;

    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->post('/api/logout')
        ->assertStatus(200);
});
