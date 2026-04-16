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

        'drivers_verified'   => Driver::where('is_verified', 1)->count(),
        'drivers_unverified' => Driver::where('is_verified', 0)->count(),

        'trips_avenir'   => Trip::where('status', 'avenir')->count(),
        'trips_encours'  => Trip::where('status', 'encours')->count(),
        'trips_terminer' => Trip::where('status', 'terminer')->count(),

        'total_revenue'  => Trip::where('status', 'terminer')->sum('price'),
        'revenue_today'  => Trip::where('status', 'terminer')
                               ->whereDate('updated_at', today())
                               ->sum('price'),

        'trips_today'   => Trip::whereDate('created_at', today())->count(),
        'users_today'   => User::whereDate('created_at', today())->count(),

        'recent_trips'  => Trip::with(['passenger', 'driver'])
                              ->latest()->take(5)->get(),

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
    public function showUser(string $id)
{
    $user = User::findOrFail($id);

    $user->load('tripsAsDriver', 'tripsAsPassenger');
    $user->trips = $user->tripsAsDriver->merge($user->tripsAsPassenger);

    return view('admin.show_users', compact('user'));
}


}




























