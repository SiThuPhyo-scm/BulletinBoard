<?php

namespace App\Contracts\Dao\Post;

interface PostDaoInterface
{
  public function getPost($auth_id, $type);
  public function postDetail($post_id);
  public function store($auth_id, $post);
  public function update($user_id, $post);
  public function searchPost($search_keyword, $auth_id, $auth_type);
  public function import($auth_id, $filepath);
  public function softDelete($auth_id,$post_id);
}
