<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class SignupController extends Controller
{
    /**
     * Show a user registration form
     */
    function showForm(){
        return response()->view('auth.signup');
    }


    /**
     * Process a submitted user registration request
     */
    function signup(SignupRequest $request){
        try{

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Login the just created user
            Auth::login($user);

            // Redirect to the dashboard
            return redirect()->route('app.dashboard');

        }catch(\Exception $e){
            return back()
                ->withInput()
                ->withErrors([
                    'status' => Lang::get('app.server_error')
                ]);
        }
    }
}
