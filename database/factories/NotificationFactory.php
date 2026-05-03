<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'type' => $this->faker->randomElement([
                Notification::TYPE_TRIP_CREATED,
                Notification::TYPE_TRIP_ACCEPTED,
                Notification::TYPE_TRIP_FINISHED,
                Notification::TYPE_TRIP_DELETED
            ]),
            'trip_id' => 1,
            'is_read' => $this->faker->boolean(),
        ];
    }
}
