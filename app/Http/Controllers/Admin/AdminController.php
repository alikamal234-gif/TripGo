<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Trip;
use App\Models\Driver;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'users_count' => User::count(),
            'trips_count' => Trip::count(),
            'drivers_count' => Driver::count(),
        ]);
    }

    public function users()
    {
        $users = User::with('role')->latest()->get();

        return view('admin.users', compact('users'));
    }

    public function trips()
    {
        $trips = Trip::with(['passenger','driver'])->latest()->get();

        return view('admin.trips', compact('trips'));
    }

    public function drivers()
    {
        $drivers = Driver::with('user')->latest()->get();

        return view('admin.drivers', compact('drivers'));
    }
}