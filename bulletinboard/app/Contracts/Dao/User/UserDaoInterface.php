<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
    public function getuser($search);
    public function show($user_id);
    public function store($auth_id, $users);
    public function profile($auth_id);
    public function edit($auth_id);
    public function update($users, $user_id);
    public function softDelete($user_id, $auth_id);
    public function changepassword($oldpwd, $newpwd, $user_id);
}
