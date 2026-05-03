<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   public function index()
    {
        $user = Auth::user();
        $role = $user->role->name;

       $notifications = Notification::with([
    'trip' => function ($query) {
        $query->withTrashed()
              ->with(['departureAddress', 'destinationAddress', 'driver', 'passenger']);
    }
])
->orderBy('created_at', 'desc')
->get();


        return view('notifications', compact('notifications'));
    }


}
