<?php

use App\Models\TravelRequest;
use App\Models\User;
use Database\Seeders\TravelStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('should update the status of the trip to approved', function () {
    $this->seed(TravelStatusSeeder::class);

    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('token')->plainTextToken;

    $trip = TravelRequest::factory(1)->create()->first();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->put('/api/request-trip/' . $trip->id . '/status', [
            'status' => 'aprovado'
        ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('travel_requests', [
        'id' => $trip->id,
        'travel_status_id' => 2
    ]);
});

it('should update the status of the trip to canceled', function () {
    $this->seed(TravelStatusSeeder::class);

    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('token')->plainTextToken;

    $trip = TravelRequest::factory(1)->create()->first();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->put('/api/request-trip/' . $trip->id . '/status', [
            'status' => 'cancelado'
        ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('travel_requests', [
        'id' => $trip->id,
        'travel_status_id' => 3
    ]);
});
