<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function getPost($auth_id, $type);

}
