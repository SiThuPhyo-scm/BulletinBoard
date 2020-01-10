<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function getPost($auth_id, $type);
    public function store($auth_id, $post);
    public function update($user_id, $post);
}
