<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /**
     * Show a user login form
     */
    function showForm(){
        return response()->view('auth.login');
    }

    /**
     * Logs out a user
     */
    function logout(Request $request){
        auth()->logout();

        return redirect()->route('account.login');
    }


    /**
     * Process a submitted user login request
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
                    ->withErrors($validator->errors());
            }

            // Attempt to login the user
            if(!auth()->attempt($request->only('email', 'password'))){
                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => Lang::get('app.invalid_credentials')
                    ]);
            }

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
