<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'trip_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }


    const TYPE_TRIP_CREATED  = 'trip_created';
    const TYPE_TRIP_ACCEPTED = 'trip_accepted';
    const TYPE_TRIP_REFUSED  = 'trip_refused';
    const TYPE_TRIP_FINISHED = 'trip_finished';



}
