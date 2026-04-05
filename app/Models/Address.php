<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'coordonnees',
        'type',
        'name'
    ];

    public function trips(){
        return $this->hasMany(Trip::class);
    }
}
