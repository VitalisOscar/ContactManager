<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show a user registration form
     */
    function showForm(){
        return response()->view('auth.login');
    }


    /**
     * Process a submitted user registration request
     */
    function login(Request $request){
        try{

            // Validate the request
            $validator = validator($request->post(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if($validator->fails()){
                return back()
                    ->withInput()
                    ->withErrors($validator);
            }

            // Attempt to login the user
            if(!auth()->attempt($request->only('email', 'password'))){
                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => 'Invalid credentials'
                    ]);
            }

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
