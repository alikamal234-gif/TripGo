<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Trip;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    return view('admin.dashboard', [
        // Stats de base
        'users_count'   => User::count(),
        'trips_count'   => Trip::count(),
        'drivers_count' => Driver::count(),

        // Stats Chauffeurs
        'drivers_verified'   => Driver::where('is_verified', 1)->count(),
        'drivers_unverified' => Driver::where('is_verified', 0)->count(),

        // Stats Trajets par statut
        'trips_avenir'   => Trip::where('status', 'avenir')->count(),
        'trips_encours'  => Trip::where('status', 'encours')->count(),
        'trips_terminer' => Trip::where('status', 'terminer')->count(),

        // Revenus
        'total_revenue'  => Trip::where('status', 'terminer')->sum('price'),
        'revenue_today'  => Trip::where('status', 'terminer')
                               ->whereDate('updated_at', today())
                               ->sum('price'),

        // Activité aujourd'hui
        'trips_today'   => Trip::whereDate('created_at', today())->count(),
        'users_today'   => User::whereDate('created_at', today())->count(),

        // Trajets récents
        'recent_trips'  => Trip::with(['passenger', 'driver'])
                              ->latest()->take(5)->get(),

        // Nouveaux utilisateurs récents
        'recent_users'  => User::latest()->take(5)->get(),
    ]);
}

    public function users()
    {
        $users = User::with('role')->latest()->paginate(5);

        return view('admin.users', compact('users'));
    }

    public function trips()
{
    $trips = Trip::with(['passenger', 'driver', 'departureAddress', 'destinationAddress'])
                 ->latest()
                 ->paginate(3);

    $stats = [
        'total'    => Trip::count(),
        'avenir'   => Trip::where('status', 'avenir')->count(),
        'accepted' => Trip::where('status', 'accepted')->count(),
        'encours'  => Trip::where('status', 'encours')->count(),
        'terminer' => Trip::where('status', 'terminer')->count(),
    ];

    return view('admin.trips', compact('trips', 'stats'));
}

    public function drivers()
    {
        $drivers = Driver::with('user')->latest()->get();

        return view('admin.drivers', compact('drivers'));
    }
    public function valider(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update([
            'is_verified' => $request->verification
        ]);


        return response()->json([
            'success' => true,
            'message' => 'driver was verified'
        ]);
    }
}






