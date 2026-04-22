<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'id' => User::factory(),
            'license_number' => $this->faker->bothify('??######'),
            'is_verified' => $this->faker->boolean(),
        ];
    }
}
