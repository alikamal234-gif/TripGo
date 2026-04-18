<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('role')->findOrFail(auth()->id());
        $role = $user->role->name;

        if ($role == "driver") {
            $user->load([
                'driver.vehicle',
                'driver.trips.departureAddress',
                'driver.trips.destinationAddress'
            ]);

            $finishedTrips = $user->driver->trips->where('status', 'terminer');
            $averageRating = $finishedTrips->avg('rating') ? number_format($finishedTrips->avg('rating'), 1) : 'Nouveau';

        } elseif ($role == "passenger") {
            $user->load([
                'passenger.trips.departureAddress',
                'passenger.trips.destinationAddress'
            ]);
            $averageRating = null;

        } else {
            abort(404);
        }

        return view('profile', compact('user', 'role', 'averageRating'));
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showDriver(string $id)
    {
        $driver = Driver::with('vehicle','trips','user')->findOrFail($id);
        return view('profileDriver',compact('driver'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'
        ]);
        $user = User::findOrFail(auth()->id());
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
