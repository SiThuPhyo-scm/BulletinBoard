<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Redirect;
use App\Models\User;
use App\Services\User\UserService;
use Auth;
use File;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Validator;

/**
 * SystemName: BulletinBoard
 * ModuleName: User
 */
class UserController extends Controller
{
    /**
     * Associated with the Service
     *
     */
    private $userService;

    /**
     * Create a new Controller instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * User List
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->getuser();
        return view('user.userList', compact('users'));
    }

    /**
     * User List with modal
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $this->userService->show($user_id=$request->id);
        return response()->json($user);
    }

    /**
     * Search User Detail
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $datefrom = $request->createfrom;
        $dateto = $request->createto;
        $users = $this->userService->search($name, $email, $datefrom, $dateto);
        return view('user.userlist', compact('users'));
    }

    /**
     * Registration New User
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createConfirm(UserRequest $request)
    {
        $validator = $request->validated();

        $name = $request->name;
        $email = $request->email;
        $pwd = $request->password;
        $type = $request->type;
        $phone = $request->phone;
        $dob = $request->dob;
        $address = $request->address;
        $profile_img = $request->file('profileImg');

        //password show as ***
        $hide = "*";
        $pwd_hide = str_pad($hide, strlen($pwd), "*");
        //tempory save profile photo
        if ($filename = $profile_img) {
            $filename = $profile_img->getClientOriginalName();
            $profile_img->move('img/tempProfile', $filename);
        }
        return view('user.createConfirm', compact(
            'name', 'email', 'pwd', 'type', 'phone', 'dob', 'address', 'pwd_hide', 'filename'
        ));
    }

    /**
     * Store User Information
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_id = Auth::user()->id;
        //save profile image
        $profile = $request->filename;
        if ($filename = $profile) {
            $oldpath = public_path() . '/img/tempProfile/' . $filename;
            $newpath = public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile = '/img/profile/' . $filename;
        } else {
            $profile = '';
        }
        $user_type = $request->type;
        if ($user_type == null) {
            $user_type = '1';
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = $user_type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->profile = $profile;
        $insert_user = $this->userService->store($auth_id, $user);
        return redirect()->intended('user')->with('success', 'User create successfully.');
    }

    /**
     * Show auth_user information
     *
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type' => 'required',
            'profileImg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $new_profile = $request->file('profileImg');

        //tempory save new profile photo
        if ($filename = $new_profile) {
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
        $profile = $request->filename;
        if ($filename = $profile) {
            $oldpath = public_path() . '/img/tempProfile/' . $filename;
            $newpath = public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile = '/img/profile/' . $filename;
        } else {
            $profile = '';
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->profile = $profile;
        $users = $this->userService->update($auth_id, $user);
        return redirect()->intended('user')
            ->withSuccess('Profile update successfully.');
    }

    /**
     * Delete User
     * @param [Request] user_id
     * @return [user]
     */
    public function destory(Request $request)
    {
        $user_id = $request->user_id;
        $auth_id = Auth::user()->id;
        $user = $this->userService->softDelete($user_id, $auth_id);
        return redirect()->intended('users')
            ->withSuccess('User delete successfully.');
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
    public function changepassword(UserRequest $request, $user_id)
    {
        $validator = $request->validated();

        $oldpwd = $request->oldpassword;
        $newpwd = $request->newpassword;
        $auth_id = Auth::user()->id;
        $status = $this->userService->changepassword($oldpwd, $newpwd, $auth_id);
        if ($status) {
            return redirect()->intended('posts')->withSuccess('Password change successfully.');
        } else {
            return redirect()->back()->with('Incorrect','Old password does not match.');
        }
    }
}
