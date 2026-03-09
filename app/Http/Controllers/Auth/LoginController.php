<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);


        if (Auth::attempt($data)) {

            $request->session()->regenerate();
            $user = Auth()->user();
            
            $role = $user->role->name;
            if ($role == 'driver') {
                return redirect()->route('driver.dashboard');
            } else if ($role == 'passenger') {
                return redirect()->route('passenger.dashboard');
            } else if ($role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}