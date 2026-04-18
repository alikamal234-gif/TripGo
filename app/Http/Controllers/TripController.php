<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Notification;
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

            $trip = Trip::create([
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

            Notification::create([
                'user_id' => auth()->id(),
                'type' => Notification::TYPE_TRIP_CREATED,
                'message' => 'Trip is Lancer',
                'trip_id' => $trip->id,
            ]);


        });

        return redirect()->route('passenger.dashboard')->with('success', 'your trip bacame lancing');
    }

    public function rate(string $id, Request $request)
    {
        $trip = Trip::findOrFail($id);

        $trip->update([
            'rating' => $request->rating,
        ]);

        return redirect()->route('passenger.dashboard');
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
    if (auth()->user()->is_driver() && auth()->user()->driver->is_verified !== 1) {
        return redirect()->route('driver.dashboard')->with('error', 'your account is not validated');
    }

    $trip = Trip::findOrFail($id);

    if (!$trip->driver_id) {
        DB::transaction(function () use ($trip) {

            $trip->update(['driver_id' => auth()->id()]);

            Notification::create([
                'user_id' => $trip->passenger_id,
                'type'    => Notification::TYPE_TRIP_ACCEPTED,
                'message' => 'Votre trajet a été accepté par un chauffeur',
                'trip_id' => $trip->id,
            ]);

            Notification::create([
                'user_id' => auth()->id(),
                'type'    => Notification::TYPE_TRIP_ACCEPTED,
                'message' => 'Vous avez accepté un trajet',
                'trip_id' => $trip->id,
            ]);
        });
    }

    return redirect()->route('driver.dashboard')->with('success', 'Trip accepted');
}

    public function start(string $id)
    {
        if (auth()->user()->is_driver() && auth()->user()->driver->is_verified !== 1) {
            return redirect()->route('driver.dashboard')->with('error', 'your account is not valider now ');
        }
        $trip = Trip::findOrFail($id);
        $trip->update([
            'status' => 'encours',
            'start_time' => now(),
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'you start trip');
    }

    public function terminer(string $id)
{
    if (auth()->user()->is_driver() && auth()->user()->driver->is_verified !== 1) {
        return redirect()->route('driver.dashboard')->with('error', 'your account is not validated');
    }

    $trip = Trip::findOrFail($id);

    DB::transaction(function () use ($trip) {

        $trip->update([
            'status'       => 'terminer',
            'termine_time' => now(),
        ]);

        // ✅ notification للـ passenger
        Notification::create([
            'user_id' => $trip->passenger_id,
            'type'    => Notification::TYPE_TRIP_FINISHED,
            'message' => 'Votre trajet est terminé',
            'trip_id' => $trip->id,
        ]);

        // ✅ notification للـ driver
        Notification::create([
            'user_id' => auth()->id(),
            'type'    => Notification::TYPE_TRIP_FINISHED,
            'message' => 'Trajet terminé avec succès',
            'trip_id' => $trip->id,
        ]);
    });

    return redirect()->route('driver.dashboard')->with('success', 'Trip finished');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trip = Trip::findOrFail($id);
        if($trip->status !== "avenir"){
            return redirect()->back()->with('error','this trip is access or terminer by driver');
        }
        $trip->delete();
        return redirect()->back()->with('success', 'this trip removed with successful');
    }
}
