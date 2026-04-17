<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'passenger_id',
        'driver_id',
        'departure_address_id',
        'destination_address_id',
        'departure_time',
        'available_seats',
        'price',
        'status',
        'rating',
        'termine_time',
        'start_time'
    ];



    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function tripsAsDriver()
{
    return $this->hasMany(Trip::class, 'driver_id');
}

public function tripsAsPassenger()
{
    return $this->hasMany(Trip::class, 'passenger_id');
}


    public function departureAddress()
    {
        return $this->belongsTo(Address::class, 'departure_address_id');
    }

    public function destinationAddress()
    {
        return $this->belongsTo(Address::class, 'destination_address_id');
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
