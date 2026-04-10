<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public $incrementing = false;

    protected $keyType = 'int';
    protected $fillable = [
        'id',
        'license_number',
        'is_verified',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'driver_id');
    }
    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
