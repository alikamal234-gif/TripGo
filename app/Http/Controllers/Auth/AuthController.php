<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }



public function callback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if ($user) {

        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleUser->getId()
            ]);
        }

        Auth::login($user);

        $role = $user->role->name;

        if ($role == 'driver') {
            return redirect()->route('driver.dashboard');
        } elseif ($role == 'passenger') {
            return redirect()->route('passenger.dashboard');
        } elseif ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/dashboard');
    }


    session([
        'google_user' => [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
        ]
    ]);

    return redirect()->route('register');
}
}
