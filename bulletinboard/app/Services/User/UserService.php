<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use App\Models\User;
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
        return $this->userDao->getuser();
    }

    /**
     * Show User information with modal
     *
     * @param $user_id
     * @return void
     */
    public function show($user_id)
    {
        return $this->userDao->show($user_id);
    }
    /**
     * Search User Details
     *
     * @param $search
     * @return void
     */
    public function search($search)
    {
        return $this->userDao->search($search);
    }

    /**
     * Password Hide and move image to temp file
     *
     * @param $pwd
     * @param $profile_img
     * @return $users
     */
    public function createConfirm($pwd, $profile_img)
    {
        $pwd_hide = str_pad('*', strlen($pwd), '*');
        if ($filename = $profile_img) {
            $filename = $profile_img->getClientOriginalName();
            $profile_img->move('img/tempProfile', $filename);
        }
        $users = new User;
        $users->pwd_hide = $pwd_hide;
        $users->filename = $filename;
        return $users;
    }

    /**
     * Registration user
     *
     * @param $auth_id
     * @param $user
     * @return void
     */
    public function store($auth_id, $user)
    {
        if ($filename = $user->profile) {
            $oldpath = public_path() . '/img/tempProfile/' . $filename;
            $newpath = public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile = '/img/profile/' . $filename;
        } else {
            $profile = '';
        }
        $user_type = $user->type;
        if ($user_type == null) {
            $user_type = '1';
        }
        $users = new User([
            'name'  => $user->name,
            'email' => $user->email,
            'password'  => $user->password,
            'type'  => $user_type,
            'phone' => $user->phone,
            'dob'   => $user->dob,
            'address'   => $user->address,
            'profile'   => $profile,
        ]);
        return $this->userDao->store($auth_id, $users);
    }

    /**
     * Show User Profile
     *
     * @param $auth_id
     * @return void
     */
    public function profile($auth_id)
    {
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
     * @param $new_profile
     * @return $filename
     */
    public function editConfirm($new_profile)
    {
        if ($filename = $new_profile) {
            $filename = $new_profile->getClientOriginalName();
            $new_profile->move('img/tempProfile', $filename);
        }
        return $filename;
    }

    /**
     * Update User Profile
     *
     * @param $auth_id
     * @param $user
     * @return void
     */
    public function update($auth_id, $user)
    {
        if ($filename = $user->profile) {
            $oldpath = public_path() . '/img/tempProfile/' . $filename;
            $newpath = public_path() . '/img/profile/' . $filename;
            File::move($oldpath, $newpath);
            $profile = '/img/profile/' . $filename;
        } else {
            $profile = '';
        }
        $users = new User([
            'name'  => $user->name,
            'email' => $user->email,
            'password'  => $user->password,
            'type'  => $user->type,
            'phone' => $user->phone,
            'dob'   => $user->dob,
            'address'   => $user->address,
            'profile'   => $profile,
        ]);
        return $this->userDao->update($auth_id, $users);
    }

    /**
     * Delete User
     *
     * @param $user_id
     * @param $auth_id
     * @return void
     */
    public function softDelete($user_id, $auth_id)
    {
        return $this->userDao->softDelete($user_id, $auth_id);
    }

    /**
     * Change Password
     *
     * @param $oldpwd
     * @param $newpwd
     * @param $auth_id
     * @return void
     */
    public function changepassword($oldpwd, $newpwd, $auth_id)
    {
        return $this->userDao->changepassword($oldpwd, $newpwd, $auth_id);
    }
}
