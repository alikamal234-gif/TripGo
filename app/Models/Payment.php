<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id',
        'passenger_id',
        'amount',
        'paid_at',
        'method',
        'status',

    ];


    public function passengers(){
        return $this->hasMany(Passenger::class);
    }
    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
