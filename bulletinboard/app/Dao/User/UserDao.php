<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;

class UserDao implements UserDaoInterface
{
    /**
     * Create Post
     * @param Object
     * @return $posts
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

}
