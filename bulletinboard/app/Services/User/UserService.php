<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use File;

class UserService implements UserServiceInterface
{
    /**
     * Associated with the UserDao
     */
    private $userDao;

    /**
     * Class Constructor
     *
     * @param UserDaoInterface $userDao
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Get User Detail
     *
     * @return void
     */
    public function getuser()
    {
        session()->forget([
            'searchkeyword',
            'name',
            'email',
            'type',
            'phone',
            'dob',
            'address',
        ]);
        return $this->userDao->getuser($search=session('search'));
    }

    /**
     * Search User
     *
     * @param $request
     * @return void
     */
    public function search($request)
    {
        $search = new User;
        $search->name = $request->name;
        $search->email = $request->email;
        $search->startdate = $request->startdate;
        $search->enddate = $request->enddate;
        session([
            'search' => $search,
        ]);
        return $this->userDao->getuser($search);
    }

    /**
     * Show User information with modal
     *
     * @param $user_id
     * @return void
     */
    public function show($user_id)
    {
        $users = $this->userDao->show($user_id);
        $users->create_user_id = $users->createuser->name;
        $users->updated_user_id = $users->updateuser->name;
        return $users;
    }

    /**
     * Password Hide and move image to temp file
     *
     * @param $request
     * @return $users
     */
    public function createConfirm($request)
    {
        $pwd = $request->password;
        $profile_img = $request->file('profileImg');
        $pwd_hide = str_pad('*', strlen($pwd), '*');
        if ($filename = $profile_img) {
            $filename = $profile_img->getClientOriginalName();
            $profile_img->move('img/tempProfile', $filename);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->pwd = $pwd;
        $user->type = $request->type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->pwd_hide = $pwd_hide;
        $user->filename = $filename;
        session([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'address' => $request->address,
        ]);
        return $user;
    }

    /**
     * Registration user
     *
     * @param $request
     * @return void
     */
    public function store($request)
    {
        if ($filename = $request->filename) {
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
        $users = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
            'type'  => $user_type,
            'phone' => $request->phone,
            'dob'   => $request->dob,
            'address'   => $request->address,
            'profile'   => $profile,
        ]);
        return $this->userDao->store($auth_id = Auth::user()->id, $users);
    }

    /**
     * Show User Profile
     *
     * @param $auth_id
     * @return void
     */
    public function profile($auth_id)
    {
        session()->forget([
            'search'
        ]);
        return $this->userDao->profile($auth_id);
    }

    /**
     * Edit User Profile
     *
     * @param $auth_id
     * @return void
     */
    public function edit($auth_id)
    {
        return $this->userDao->edit($auth_id);
    }

    /**
     * Move New Profile into temp file
     *
     * @param $request
     * @return $filename
     */
    public function editConfirm($request)
    {
        $new_profile = $request->file('profileImg');
        if ($filename = $new_profile) {
            $filename = $new_profile->getClientOriginalName();
            $new_profile->move('img/tempProfile', $filename);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->filename= $filename;
        return $user;
    }

    /**
     * Update User Profile
     *
     * @param $auth_id
     * @param $user
     * @return void
     */
    public function update($request)
    {
        if ($filename = $request->filename) {
            $oldpath = public_path() . '/img/tempProfile/' . $filename;
            $newpath = public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile = '/img/profile/' . $filename;
        } else {
            $profile = '';
        }
        $users = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password'  => $request->password,
            'type'  => $request->type,
            'phone' => $request->phone,
            'dob'   => $request->dob,
            'address'   => $request->address,
            'profile'   => $profile,
        ]);
        return $this->userDao->update($auth_id = Auth::user()->id, $users);
    }

    /**
     * Delete User
     *
     * @param $user_id
     * @param $auth_id
     * @return void
     */
    public function softDelete($request)
    {
        session()->forget([
            'search'
        ]);
        $user_id = $request->user_id;
        return $this->userDao->softDelete($user_id, $auth_id = Auth::user()->id);
    }

    /**
     * Change Password
     *
     * @param $request
     * @param $user_id
     * @return void
     */
    public function changepassword($request, $user_id)
    {
        $oldpwd = $request->oldpassword;
        $newpwd = $request->newpassword;
        return $this->userDao->changepassword($oldpwd, $newpwd, $user_id);
    }
}
