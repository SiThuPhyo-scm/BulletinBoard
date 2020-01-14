<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;

class UserDao implements UserDaoInterface
{
    /**
     * Get User List
     *
     * @return $users user data
     */
    public function getuser()
    {
        $users = User::select(
            'users.name',
            'users.email',
            'users.phone',
            'users.dob',
            'users.address',
            'users.created_at',
            'users.id',
            'u1.name as created_user_name')
            ->join('users as u1', 'u1.id', 'users.create_user_id')
            ->orderBy('users.updated_at', 'DESC')
            ->paginate(5);
          return $users;
    }

    /**
     * Create User
     * @param auth user id and user input data
     * @return $userlist
     */
    public function store($auth_id, $user)
    {
        $insert_user = new User([
        'name'            =>  $user->name,
        'email'           =>  $user->email,
        'password'        =>  $user->password,
        'profile'         =>  $user->profile,
        'type'            =>  $user->type,
        'phone'           =>  $user->phone,
        'address'         =>  $user->address,
        'dob'             =>  $user->dob,
        'create_user_id'  =>  $auth_id,
        'updated_user_id' =>  $auth_id
        ]);
        $insert_user->save();
        return redirect()->back();
    }

    /**
     * Show auth_user information
     *
     * @param [auth_id] login user id
     * @return [user_profile] user detail where auth_id
     */
    public function profile($auth_id)
    {
        $user_profile = User::find($auth_id);
        return $user_profile;
    }

    /**
     * Edit auth_user information
     *
     * @param [auth_id] login user id
     * @return [users] information where auth_id
     */
    public function edit($auth_id)
    {
        $users = User::find($auth_id);
        return $users;
    }

    /**
     * Update User Profile
     *
     * @param [$user_id] auth id
     * @param [$user] user edit data
     * @return [userlist] update successfully message
     */
    public function update($auth_id, $user)
    {
        $update = User::find($auth_id);
        $update->name = $user->name;
        $update->email = $user->email;
        $update->type = $user->type;
        $update->phone = $user->phone;
        $update->address = $user->address;
        $update->profile = $user->profile;
        $update->updated_user_id = $auth_id;
        $update->updated_at = now();
        $update->save();
        $users = User::where('create_user_id', $auth_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(5);
        return $users;
    }
}
