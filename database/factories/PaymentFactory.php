<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Trip;
use App\Models\Passenger;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'trip_id' => 1,
            'passenger_id' => 1,
            'amount' => $this->faker->randomFloat(0, 10, 200),
            'paid_at' => clone $this->faker->dateTimeThisMonth(),
            'method' => $this->faker->randomElement(['cash', 'online']),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
