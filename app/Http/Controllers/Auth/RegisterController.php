<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        $googleUser = session('google_user');

        return view('auth.register', compact('googleUser'));
    }

    public function registerUser(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string'],
            'ville' => ['required', 'string'],
            'postal_code' => ['required', 'numeric'],
            'date_birth' => ['required', 'date'],
            'password' => [
                $request->session()->has('google_user') ? 'nullable' : 'required',
                'confirmed',
                Password::min(8)->letters()->numbers(),
            ],
            'role' => ['required', 'exists:roles,name', 'in:driver,passenger'],

            'licenseNumber' => ['nullable', 'string'],
            'vehicleType' => ['nullable', 'string'],
            'vehicleColor' => ['nullable', 'string'],
            'seatCount' => ['nullable', 'integer'],
            'vehiclePlate' => ['nullable', 'string'],
        ]);
        // dd($data);
        $user = DB::transaction(function () use ($data, $request) {

            $roleId = DB::table('roles')
                ->where('name', $data['role'])
                ->value('id');

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'date_birth' => $data['date_birth'],
                'ville' => $data['ville'],
                'postal_code' => $data['postal_code'],
                'password' => $request->session()->has('google_user')
                    ? null
                    : Hash::make($data['password']),
                'role_id' => $roleId,
                'google_id' => (string) session('google_user.google_id') ?? null,
            ]);

            if ($data['role'] === 'driver') {
                $this->registerDriver($user->id, $request);
            }

            if ($data['role'] === 'passenger') {
                Passenger::create([
                    'id' => $user->id,
                    'preferred_payment_method' => 'cash',
                ]);
            }

            return $user;
        });

        Auth::login($user);

        session()->forget('google_user');
        $request->session()->regenerate();

        $role = $user->role->name;

        if ($role == 'driver') {
            return redirect()->route('driver.dashboard');
        } elseif ($role == 'passenger') {
            return redirect()->route('passenger.dashboard');
        } elseif ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/dashboard');
    }

    // public function message()
    // {
    //     ['role.message' => 'wrong role'];
    // }

    public function registerDriver(string $id, Request $request)
    {

        $driver = Driver::create([
            'id' => (int) $id,
            'license_number' => $request->licenseNumber,
            'is_verified' => false,
        ]);
        Vehicle::create([
            'driver_id' => $driver->id,
            'vehicle_plate' => $request->vehiclePlate,
            'type' => $request->vehicleType,
            'num_seats' => $request->seatCount,
            'coulour' => $request->vehicleColor,
            'is_active' => false,
        ]);

    }
}
