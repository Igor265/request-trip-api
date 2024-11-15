<?php

namespace Database\Factories;

use App\Models\TravelRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelRequest>
 */
class TravelRequestFactory extends Factory
{
    protected $model = TravelRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requester_name' => $this->faker->name,
            'requester_email' => $this->faker->safeEmail,
            'destination' => $this->faker->city,
            'departure_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'return_date' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'travel_status_id' => 1, // Assuming 1 is a valid status ID
        ];
    }
}
