<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * User Login
     * Login action using user email and password
     *
     * @param LoginRequest $request
     * @return [view] Post List
     */
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $pwd = $request->password;
        $validator = $request->validated();
        
        if (Auth::guard('')->attempt(['email' => $email, 'password' => $pwd])) {
            return redirect()->intended('/post');
        } else {
            return back()
                ->with('incorrect', 'Email or password incorrect!')
                ->withInput();
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
