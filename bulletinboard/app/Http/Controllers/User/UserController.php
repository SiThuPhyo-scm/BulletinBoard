<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Services\User\UserServiceInterface;
use App\Services\User\UserService;
use App\Http\Controllers\Redirect;
use App\Models\User;
use Validator;
use Auth;
use Hash;
use File;
use Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $user)
    {
        $this->userService = $user;
    }
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
            return redirect()->intended('posts');
        } else {
            return back()
                ->with('incorrect', 'Email or password incorrect!')
                ->withInput();
        }
    }

    /**
     * Registration New User
     *
     * @return [view] create user page
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param [Request] $request
     *
     * @return [View] create user confirmation page
     */
    public function createConfirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'email'     =>  'required|email|unique:users,email',
            'password'  =>  'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'type'  => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $name    =  $request->name;
        $email   =  $request->email;
        $pwd     =  $request->password;
        $type    =  $request->type;
        $phone   =  $request->phone;
        $dob     =  $request->dob;
        $address =  $request->address;
        $profile_img =  $request->file('profile');

        //password show as ***
        $hide = "*";
        $pwd_hide = str_pad($hide, strlen($pwd), "*");
        //tempory save profile photo
        $filename = "";
        if ($profile_img) {
            $filename = $profile_img->getClientOriginalName();
            $profile_img->move('img/tempProfile', $filename);
        }
        session ([
            'name'  => $name,
            'email' => $email,
            'type'  => $type,
            'phone' => $phone,
            'dob'   => $dob,
            'address' => $address
        ]);
        return view('User.createConfirm', compact(
            'name', 'email','pwd', 'type', 'phone', 'dob', 'address', 'pwd_hide', 'filename'
        ));
    }

    /**
     * Store User Information
     *
     * @param [Request] $request
     * @return [view] userlist
     */
    public function store(Request $request)
    {
        $auth_id    =  Auth::user()->id;
        //save profile image
        $filename  =  $request->filename;
        if ($filename) {
            $oldpath    =  public_path() . '/img/tempProfile/' . $filename;
            $newpath    =  public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile    =  '/img/profile/' . $filename;
        } else {
            $profile    =  '';
        }
        $user_type      =  $request->type;
        if ($user_type == null) {
            $user_type = '1';
        }
        $user           =  new User;
        $user->name     =  $request->name;
        $user->email    =  $request->email;
        $user->password =  Hash::make($request->password);
        $user->type     =  $user_type;
        $user->phone    =  $request->phone;
        $user->dob      =  $request->dob;
        $user->address  =  $request->address;
        $user->profile  =  $profile;
        $insert_user  =  $this->userService->store($auth_id, $user);
        return redirect()->intended('posts')->with('success', 'User create successfully.');
    }
}
