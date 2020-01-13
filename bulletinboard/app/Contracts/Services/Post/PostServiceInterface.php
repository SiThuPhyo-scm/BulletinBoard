<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function getPost($auth_id, $type);
    public function store($auth_id, $post);
    public function edit($post_id);
    public function update($user_id, $post);
}
