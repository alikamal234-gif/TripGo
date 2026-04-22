<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleDriver = Role::firstOrCreate(['name' => 'driver']);
        $rolePassenger = Role::firstOrCreate(['name' => 'passenger']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@tripgo.test',
            'role_id' => $roleAdmin->id,
        ]);

        $driverUsers = User::factory(10)->create(['role_id' => $roleDriver->id]);
        foreach ($driverUsers as $user) {
            $driver = \App\Models\Driver::factory()->create(['id' => $user->id]);
            \App\Models\Vehicle::factory()->create(['driver_id' => $driver->id]);
        }

        $passengerUsers = User::factory(15)->create(['role_id' => $rolePassenger->id]);
        $passengers = collect();
        foreach ($passengerUsers as $user) {
            $passengers->push(\App\Models\Passenger::factory()->create(['id' => $user->id]));
        }

        $addresses = \App\Models\Address::factory(20)->create();

        $driverModels = \App\Models\Driver::all();

        $trips = collect();
        for ($i = 0; $i < 30; $i++) {
            $trips->push(\App\Models\Trip::factory()->create([
                'passenger_id' => $passengers->random()->id,
                'driver_id' => $driverModels->random()->id,
                'departure_address_id' => $addresses->random()->id,
                'destination_address_id' => $addresses->random()->id,
            ]));
        }

        $selectedTrips = $trips->shuffle()->take(20);

foreach ($selectedTrips as $trip) {
    \App\Models\Payment::factory()->create([
        'trip_id' => $trip->id,
        'passenger_id' => $trip->passenger_id,
    ]);
}

        $usersForNotifications = User::all();
        for ($i = 0; $i < 50; $i++) {
            \App\Models\Notification::factory()->create([
                'user_id' => $usersForNotifications->random()->id,
                'trip_id' => $trips->random()->id,
            ]);
        }
    }
}
