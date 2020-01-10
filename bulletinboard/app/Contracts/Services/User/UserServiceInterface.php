<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
    public function store($auth_id, $post);
}
