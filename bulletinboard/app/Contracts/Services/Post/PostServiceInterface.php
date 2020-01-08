<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function store($auth_id, $post);
    
}
