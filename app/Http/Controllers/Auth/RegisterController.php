<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','min:2'],
            'email' => ['required','email'],
            'phone' => ['required','numeric'],
            'password' => ['required','confirmed',Password::min(8)->letters()->numbers()],
            'role' => ['required','exists:roles,name'],

            'licenseNumber' => ['nullable','string'],
            'city' => ['nullable','string'],
            'vehicleType' => ['nullable','string'],
            'vehicleColor' => ['nullable','string'],
            'seatCount' => ['nullable','integer'],
            'vehiclePlate' => ['nullable','string']
        ]);

        DB::transaction(function () use ($data,$request) {

            $roleId = DB::table('roles')
                ->where('name',$data['role'])
                ->value('id');

            $user = User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'phone'=>$data['phone'],
                'password'=>Hash::make($data['password']),
                'role_id'=>$roleId
            ]);

            if($data['role'] === 'driver'){
                $this->registerDriver($user->id,$request);
            }

            if($data['role'] === 'passenger'){
                Passenger::create([
                    'id'=>$user->id,
                    'num_trip'=>0
                ]);
            }

        });

        return redirect()->route('login')
            ->with('success','Compte créé avec succès');
    }


    public function registerDriver(string $id, Request $request)
    {

        $driver = Driver::create([
            'id'=>(int)$id,
            'license_number'=>$request->licenseNumber,
            'ville'=>$request->city,
            'is_verified'=>false
        ]);
        Vehicle::create([
            'driver_id'=>$driver->id,
            'vehicle_plate'=>$request->vehiclePlate,
            'type'=>$request->vehicleType,
            'num_seats'=>$request->seatCount,
            'coulour'=>$request->vehicleColor,
            'is_active'=>false
        ]);

    }
}