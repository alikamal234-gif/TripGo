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
                'trip.departureAddress',
                'trip.destinationAddress',
                'trip.driver',         
                'trip.passenger'      
            ])
            ->orderBy('created_at', 'desc')
            ->get();


        return view('notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}