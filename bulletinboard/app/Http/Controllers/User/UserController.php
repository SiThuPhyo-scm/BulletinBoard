<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Redirect;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Customer Login
     *
     * Login action using user email and password
     * @param [Request] $request
     * @return [View] postlist
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $pwd = $request->password;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if (Auth::guard('')->attempt(['email' => $email, 'password' => $pwd])) {
            return redirect()->intended('/home');
        } else {
            return redirect()->back()
                ->with('incorrect', 'Email or password incorrect!')
                ->withInput();
        }
    }
}
