<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'preferred_payment_method'
    ];

    public function user(){
        return $this->belongsTo(User::class,'id');
    }

    public function trips(){
        return $this->hasMany(Trip::class);
    }


}
