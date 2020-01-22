<?php

namespace App\Contracts\Dao\Post;

interface PostDaoInterface
{
    public function getPost($auth_id, $type);
    public function search($auth_id, $type, $searchkeyword);
    public function store($auth_id, $post);
    public function edit($post_id);
    public function update($user_id, $post);
    public function softDelete($auth_id, $post_id);
}
