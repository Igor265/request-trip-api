<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should register a new user', function () {
    $this->post('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password'
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com'
    ]);

});
