<?php

namespace App\Contracts\Services\Post;

interface PostServiceInterface
{
    public function getPost($request);
    public function show($post_id);
    public function createConfirm($request);
    public function edit($post_id);
    public function update($request, $post_id);
    public function softDelete($auth_id, $post_id);
    public function import($request);
}
