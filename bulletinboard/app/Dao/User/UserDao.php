<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Hash;

class UserDao implements UserDaoInterface
{
    /**
     * Get User List
     *
     * @return $users
     */
    public function getuser($search)
    {
        if ($search == null) {
            $users = User::orderBy('users.updated_at', 'DESC')->paginate(5);
        } elseif ($search->name == null && $search->email == null && ($search->startdate == null || $search->enddate == null)) {
            $users = User::orderBy('users.updated_at', 'DESC')->paginate(5);
        } else {
            if ((isset($search->name) && isset($search->email)) && (is_null($search->startdate) || is_null($search->enddate))) {
                $users = User::where('users.name', 'LIKE', '%' . $search->name . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $search->email . '%')
                    ->orderBy('users.updated_at', 'DESC')
                    ->paginate(5);
            } else if ((isset($search->name) || isset($search->email)) && (is_null($search->startdate) || is_null($search->enddate))) {
                $users = User::where('users.name', 'LIKE', '%' . $search->name . '%')
                    ->where('users.email', 'LIKE', '%' . $search->email . '%')
                    ->orderBy('users.updated_at', 'DESC')
                    ->paginate(5);
            } else if (isset($search->startdate) && isset($search->enddate)) {
                $users = User::whereBetween('users.created_at', array($search->startdate, $search->enddate))
                    ->orderBy('users.updated_at', 'DESC')
                    ->paginate(5);
            }
        }
        return $users;
    }

    /**
     * Show User Information with modal
     *
     * @param $user_id
     * @return $user
     */
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        return $user;
    }

    /**
     * Store User Information into the database
     *
     * @param $auth_id
     * @param $user
     */
    public function store($auth_id, $users)
    {
        $insert_user = new User([
        'name'            =>  $users->name,
        'email'           =>  $users->email,
        'password'        =>  $users->password,
        'profile'         =>  $users->profile,
        'type'            =>  $users->type,
        'phone'           =>  $users->phone,
        'address'         =>  $users->address,
        'dob'             =>  $users->dob,
        'create_user_id'  =>  $auth_id,
        'updated_user_id' =>  $auth_id
        ]);
        $insert_user->save();
        return redirect()->back();
    }

    /**
     * Show user profile
     *
     * @param $auth_id
     * @return $user_profile
     */
    public function profile($auth_id)
    {
        $user_profile = User::find($auth_id);
        return $user_profile;
    }

    /**
     * Edit user profile
     *
     * @param $auth_id
     * @return $user
     */
    public function edit($auth_id)
    {
        $users = User::find($auth_id);
        return $users;
    }

    /**
     * Update User Profile
     *
     * @param $auth_id
     * @param $users
     * @return $users
     */
    public function update($auth_id, $users)
    {
        $update = User::find($auth_id);
        $update->name = $users->name;
        $update->email = $users->email;
        $update->type = $users->type;
        $update->phone = $users->phone;
        $update->address = $users->address;
        $update->profile = $users->profile;
        $update->updated_user_id = $auth_id;
        $update->updated_at = now();
        $update->save();
        $users = User::where('create_user_id', $auth_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);
        return $users;
    }

    /**
     * SoftDelete User
     *
     * @param $user_id
     * @param $auth_id
     */
    public function softDelete($user_id, $auth_id)
    {
        $delete_user = User::findOrfail($user_id);
        $delete_user->deleted_user_id = $auth_id;
        $delete_user->deleted_at = now();
        $delete_user->save();
    }

    /**
     * Change Password
     *
     * @param $oldpwd
     * @param $newpwd
     * @param $user_id
     * @return $status
     */
    public function changepassword($oldpwd, $newpwd, $user_id)
    {
        $update_user = User::find($user_id);
        $status = Hash::check($oldpwd, $update_user->password);
        if ($status) {
            $update_user->password   = Hash::make($newpwd);
            $update_user->updated_user_id = $user_id;
            $update_user->updated_at = now();
            $update_user->save();
            return $status;
        }
    }

}
