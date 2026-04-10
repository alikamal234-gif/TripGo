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
    public function valider(Request $request,string $id){
        $driver = Driver::findOrFail($id);
        $driver->update([
            'is_verified' => $request->verification
        ]);
        return redirect()->route('admin.drivers')->with('success', "driver $driver->name is valider for use app");
    }
}