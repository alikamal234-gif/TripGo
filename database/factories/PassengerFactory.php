<?php

namespace Database\Factories;

use App\Models\Passenger;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassengerFactory extends Factory
{
    protected $model = Passenger::class;

    public function definition(): array
    {
        return [
            'id' => User::factory(),
            'num_trip' => $this->faker->numberBetween(0, 50),
        ];
    }
}
