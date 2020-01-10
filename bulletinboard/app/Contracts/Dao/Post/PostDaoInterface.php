<?php

namespace App\Contracts\Dao\Post;

interface PostDaoInterface
{
    public function getPost($auth_id, $type);
    public function store($auth_id, $post);
    public function update($user_id, $post);
}
