<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Models\Passenger;
use App\Models\Driver;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        return [
            'passenger_id' => 1,
            'driver_id' => 1,
            'departure_address_id' => 1,
            'destination_address_id' => 1,
            'departure_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'available_seats' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->randomFloat(0, 10, 200),
            'status' => $this->faker->randomElement(['avenir', 'encours', 'terminer']),
            'rating' => $this->faker->numberBetween(0, 5),
            'start_time' => null,
            'termine_time' => null,
        ];
    }
}
