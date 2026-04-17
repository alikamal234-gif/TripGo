<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'trip_id',
        'passenger_id',
        'driver_id',
        'amount',
        'paid_at',
        'method',
        'status',

    ];

    public function drivers(){
        return $this->hasMany(Driver::class);
    }

    public function passengers(){
        return $this->hasMany(Passenger::class);
    }
    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
