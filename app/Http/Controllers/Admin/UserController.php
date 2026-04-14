<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function edit(string $id){
        $user = User::findOrFail($id);

        if($user->role->name == "driver"){
            $user = $user->load('driver','driver.vehicle','role');
        }else if($user->role->name == "passenger"){
            $user = $user->load('passenger','role');
        }
        return view('admin.edit_users', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function update(string $id,Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','min:2'],
            'email' => ['required','email'],
            'phone' => ['required','string'],
            'ville' => ['required','string'],
            'role' => ['required','exists:roles,name'],

            'licenseNumber' => ['nullable','string'],
            'vehicleType' => ['nullable','string'],

        ]);
        $user = User::findOrFail($id);
        DB::transaction(function () use ($id,$user,$data,$request) {

            $roleId = DB::table('roles')
                ->where('name',$data['role'])
                ->value('id');

            $user->update([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'phone'=>$data['phone'],
                'ville' => $data['ville'],
                'role_id'=>$roleId
            ]);

            if($data['role'] === 'driver'){
                $this->updateDriver($id,$data);
            }


        });
    return redirect()->back();
    }
    public function updateDriver($id, $data){
        $driver = Driver::findOrFail($id);
         $driver->update([
            'license_number'=>$data['licenseNumber'],
        ]);
        $vehicle = Vehicle::where('driver_id', $driver->id);
        $vehicle->update([
            'type'=>$data['vehicleType']
        ]);
        return redirect()->back();
    }
}
