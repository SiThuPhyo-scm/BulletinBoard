<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    public function getuser($request);
    public function show($user_id);
    public function createConfirm($request);
    public function store($request);
    public function profile($auth_id);
    public function edit($auth_id);
    public function editConfirm($request);
    public function update($request);
    public function softDelete($request);
    public function changepassword($request, $user_id);
}
