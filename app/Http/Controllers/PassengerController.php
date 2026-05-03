<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class PassengerController extends Controller
{
    public function index()
    {
        $trips = Trip::with([
            'driver',
            'departureAddress',
            'destinationAddress',
            'payment',
        ])
            ->where('passenger_id', auth()->id())
            ->latest()
            ->get();

        return view('passenger.dashboard', compact('trips'));
    }
}
