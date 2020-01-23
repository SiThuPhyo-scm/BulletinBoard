<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
    public function getuser();
    public function search($name, $email, $datefrom, $dateto);
    public function show($user_id);
    public function store($auth_id, $post);
    public function profile($auth_id);
    public function edit($auth_id);
    public function update($user, $user_id);
    public function softDelete($user_id, $auth_id);
    public function changepassword($oldpwd, $newpwd, $auth_id);
}
