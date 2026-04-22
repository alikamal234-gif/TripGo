<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'driver_id' => 1,
            'vehicle_plate' => $this->faker->bothify('??-###-??'),
            'type' => $this->faker->randomElement(['Sedan', 'SUV', 'Hatchback']),
            'num_seats' => $this->faker->numberBetween(1, 4),
            'coulour' => $this->faker->safeColorName(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
