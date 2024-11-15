<?php

use App\Models\TravelRequest;
use App\Models\User;
use Database\Seeders\TravelStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('should list all the trips', function () {
    $this->seed(TravelStatusSeeder::class);
    TravelRequest::factory(5)->create();
    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->get('/api/request-trip');

    $response->assertStatus(200);
    $response->assertJsonCount(5, 'data');
});

it('should not list without a token', function () {
    $this->seed(TravelStatusSeeder::class);
    TravelRequest::factory(5)->create();

    $response = $this->withHeader('Accept', 'application/json')
        ->get('/api/request-trip');

    $response->assertStatus(401);
});

it('should show a specific trip', function () {
    $this->seed(TravelStatusSeeder::class);
    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('token')->plainTextToken;

    $trip = TravelRequest::factory(1)->create()->first();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->get('/api/request-trip/' . $trip->id);

    $response->assertStatus(200);

    $responseData = $response->json('data');

    $this->assertEquals($trip->id, $responseData['id']);
});
