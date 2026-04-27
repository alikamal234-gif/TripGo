<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Passenger::with('trips.driver','trips.departureAddress', 'trips.destinationAddress','trips.payment')
            ->findOrFail(auth()->id());

        $trips = $user->trips()->latest()->get();
        return view('passenger.dashboard', compact('trips'));
    }
}
