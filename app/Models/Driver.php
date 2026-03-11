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
        'ville'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
