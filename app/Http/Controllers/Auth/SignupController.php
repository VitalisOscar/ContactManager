<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                    'status' => 'Something went wrong on our end. You can try again or leave us a message if that persists'
                ]);
        }
    }
}
