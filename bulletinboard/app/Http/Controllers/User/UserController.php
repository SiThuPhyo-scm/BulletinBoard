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

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show Users Detail
     *
     * @return [view] User List
     */
    public function index()
    {
        if(Auth::check() && Auth::user()->type==0) {
            session()->forget([
                'name',
                'email',
                'type',
                'phone',
                'dob',
                'address',
                'search_name',
                'search_email',
                'search_date_from',
                'search_date_to'
            ]);
            $users = $this->userService->getuser();
            return view('user.userList', compact('users'));
        }
        else {
            return redirect()->back();
        }
    }

    /**
     * Search User Detail
     * @param [request]
     * @return [userlist]
     */
    public function search(Request $request)
    {
        $name   = $request->name;
        $email  = $request->email;
        $datefrom = $request->createfrom;
        $dateto   = $request->createto;
        if ($email) {
            $validator = Validator::make($request->all(), [
                'email' => 'email'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            }
        }
        $users = $this->userService->search($name, $email, $datefrom, $dateto);
        return view('user.userlist', compact('users'));
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
     * @param [Request] input data
     *
     * @return [View] create user confirmation page
     */
    public function createConfirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'email'     =>  'required|email|unique:users,email',
            'password'  =>  'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'confirm_password' => 'required|min:8|same:password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'type'      => 'required',
            'profileImg'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        $profile_img =  $request->file('profileImg');

        //password show as ***
        $hide = "*";
        $pwd_hide = str_pad($hide, strlen($pwd), "*");
        //tempory save profile photo
        if ($filename=$profile_img) {
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
        return view('user.createConfirm', compact(
            'name', 'email','pwd', 'type', 'phone', 'dob', 'address', 'pwd_hide', 'filename'
        ));
    }

    /**
     * Store User Information
     *
     * @param [Request] after validation user input
     * @return [view] userlist
     */
    public function store(Request $request)
    {
        $auth_id    =  Auth::user()->id;
        //save profile image
        $profile  =  $request->filename;
        if ($filename=$profile) {
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
        return redirect()->intended('users')->with('success', 'User create successfully.');
    }

    /**
     * Show auth_user information
     *
     * @param
     * @return [view] Profile with auth_user information
     */
    public function profile()
    {
        $user_id = Auth::user()->id;
        $user_profile = $this->userService->profile($user_id);
        return view('user.profile', compact('user_profile'));
    }

    /**
     * Show the form for Update User
     *
     * @param $user_id
     * @return [view] Update User with auth_user information
     */
    public function edit($user_id)
    {
        $users = $this->userService->edit($user_id);
        return view('user.edit', compact('users'));
    }
    /**
     * Update user after a valid registration.
     *
     * @param [Request] input user data
     * @param [auth user id]
     * @return [view] Update User confirmation afer validation
     */
    public function editConfirm(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $email = $request->email;
        $validator = Validator::make($request->all(), [
            'name' =>  'required',
            'email'     =>  'required|email|unique:users,email,' . $user->id,
            'type'     =>  'required',
            'profileImg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user   =   new User;
        $user->name    =  $request->name;
        $user->email   =  $request->email;
        $user->type    =  $request->type;
        $user->phone   =  $request->phone;
        $user->dob     =  $request->dob;
        $user->address =  $request->address;
        $new_profile   =  $request->file('profileImg');

         //tempory save new profile photo
        if ($filename=$new_profile) {
            $filename = $new_profile->getClientOriginalName();
            $new_profile->move('img/tempProfile', $filename);
        }
        return view('user.editConfirm', compact('user', 'filename', 'user_id'));
    }

    /**
     * Update Profile in database
     *
     * @param [Request] edit user input
     * @param $user_id
     * @return [userlist] with successfully message.
     */
    public function update(Request $request, $user_id)
    {
        $user = new User;
        $auth_id = Auth::user()->id;
        $profile  =  $request->filename;
        if ($filename=$profile) {
            $oldpath    =  public_path() . '/img/tempProfile/' . $filename;
            $newpath    =  public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile    =  '/img/profile/' . $filename;
        } else {
            $profile    =  '';
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->profile = $profile;
        $users = $this->userService->update($auth_id, $user);
        return redirect()->intended('users')
            ->withSuccess('Profile update successfully.');
    }

    /**
     * Change Password
     *
     * @param [old password]
     * @param [new password] user change password
     * @return [view] change password form with user_id
     */
    public function password($user_id)
    {
        return view('user.password', compact('user_id'));
    }

    /**
     * Store Change Password after validation
     *
     * @param [Request] old password and new password
     * @param [user_id]
     * @return redirect postlist
     */
    public function passwordchange(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword'    =>'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'newpassword'    =>'required|min:8|different:oldpassword|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'confirmpassword'=>'required|min:8|same:newpassword|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    }
}
