<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
     protected $fillable = [
        'driver_id',
        'vehicle_plate',
        'type',
        'num_seats',
        'coulour',
        'is_active'
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(){
        return $this->belongsTo(Driver::class);
    }
}
