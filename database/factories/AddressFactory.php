<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'coordonnees' => $this->faker->latitude() . ',' . $this->faker->longitude(),
            'type' => $this->faker->randomElement(['departure', 'destination']),
            'name' => $this->faker->city(),
        ];
    }
}
