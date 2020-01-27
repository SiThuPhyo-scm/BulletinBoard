<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    public function getuser();
    public function search($search);
    public function show($user_id);
    public function store($auth_id, $post);
    public function profile($auth_id);
    public function edit($auth_id);
    public function update($auth_id, $user);
    public function softDelete($user_id, $auth_id);
    public function changepassword($oldpwd, $newpwd, $auth_id);
}
