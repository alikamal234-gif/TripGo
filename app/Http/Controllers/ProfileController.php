<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;


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
     * Display the specified resource.
     */
    public function showDriver(string $id)
    {
        $driver = Driver::with('vehicle','trips','user')->findOrFail($id);
        return view('profileDriver',compact('driver'));

    }


}
