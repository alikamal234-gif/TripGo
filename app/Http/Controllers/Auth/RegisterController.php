<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.register');
    }

   public function registerUser(Request $request){
        $data = $request->validate([
            'name' => ['required','string','min:0'],
            'email' => ['required','email'],
            'phone' => ['required','numeric'],
            'password' => ['required','confirmed',Password::min(8)->letters()->numbers()],
            'role' => ['exists:roles,name']
        ]);
        dd($data);
        DB::transaction(function () use($data){
            User::create($data);

            if($data['role'] == ''){

            }else if($data['role'] == ''){

            }
        });
   }
   public function registerDriver(){

   }
}
