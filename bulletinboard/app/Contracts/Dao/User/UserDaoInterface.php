<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
    public function store($auth_id, $post);
}
