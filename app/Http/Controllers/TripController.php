<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Trip;
use DB;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([

            'departure' => ['required'],
            'departure_name' => ['required', 'string'],
            'destination_name' => ['required', 'string'],
            'destination' => ['required', 'string'],
            'departure_time' => ['required', 'date'],
            'available_seats' => ['required'],
            'price' => ['required', 'numeric'],
        ]);

        DB::transaction(function () use ($data) {

            $departure = Address::create([
                'coordonnees' => $data['departure'],
                'name' => $data['departure_name'],
                'type' => 'departure',
            ]);
            $destination = Address::create([
                'coordonnees' => $data['destination'],
                'name' => $data['destination_name'],
                'type' => 'destination',
            ]);

            Trip::create([
                'passenger_id' => auth()->id(),
                'driver_id' => null,
                'departure_address_id' => $departure->id,
                'destination_address_id' => $destination->id,
                'departure_time' => $data['departure_time'],
                'available_seats' => $data['available_seats'],
                'price' => $data['price'],
                'rating' => 0,
                'status' => 'avenir',
            ]);

        });

        return redirect()->route('passenger.dashboard')->with('success', 'your trip bacame lancing');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function accept(string $id)
    {
        $trip = Trip::findOrFail($id);
        if (! $trip->driver_id) {
            $trip->update([
                'driver_id' => auth()->id(),
            ]);
        }
        return redirect()->route('driver.dashboard')->with('success', 'you accept one trip');
    }

    public function start(string $id){
        $trip = Trip::findOrFail($id);
            $trip->update([
                'status' => 'encours',
                'start_time' => now()
            ]);
        return redirect()->route('driver.dashboard')->with('success', 'you start trip');
    }

    public function terminer(string $id){
        $trip = Trip::findOrFail($id);
            $trip->update([
                'status' => 'terminer',
                'termine_time' => now()
            ]);
        return redirect()->route('driver.dashboard')->with('success', 'your trip is finished');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
