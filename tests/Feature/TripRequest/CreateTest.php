<?php

use App\Models\User;
use Database\Seeders\TravelStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('should be able to create a new trip', function () {
    $this->seed(TravelStatusSeeder::class);

    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->post('/api/request-trip', [
            'nome_solicitante' => 'John Doe',
            'email_solicitante' => 'test@test.com',
            'destino' => 'New York',
            'data_ida' => '2024-12-01',
            'data_volta' => '2024-12-10',
            'status' => 'solicitado'
        ]);

    $response->assertStatus(201);

    $responseData = $response->json('data');

    $this->assertDatabaseHas('travel_requests', [
        'id' => $responseData['id']
    ]);
});

it('should not be able to create a new trip without a token', function () {
    $response = $this->withHeader('Accept', 'application/json')
        ->post('/api/request-trip', [
            'nome_solicitante' => 'John Doe',
            'email_solicitante' => 'test@test.com',
            'destino' => 'New York',
            'data_ida' => '2024-12-01',
            'data_volta' => '2024-12-10',
            'status' => 'solicitado'
        ]);

    $response->assertStatus(401);
});
