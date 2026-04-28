<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $trips = Trip::with('payment')
        ->latest()
        ->whereNull('driver_id')
        ->get();

    $trips_accept = Trip::with('payment')
        ->where('driver_id', auth()->id())
        ->latest()
        ->get();

    return view('driver.dashboard', compact('trips', 'trips_accept'));
}

}
