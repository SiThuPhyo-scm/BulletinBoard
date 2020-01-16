<?php

namespace App\Dao\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;

class PostDao implements PostDaoInterface
{
    /**
     * Get Posts List
     * @param auth user id and user type
     * @return $posts
     */
    public function getPost($auth_id, $type)
    {
        if ($type == '0') {
            $posts = Post::orderBy('updated_at', 'DESC')->paginate(5);
        } else {
            $posts = Post::where('create_user_id', $auth_id)
                ->orderBy('updated_at', 'DESC')
                ->paginate(5);
        }
        return $posts;
    }

    /**
     * Search Post Details
     *
     * @param [auth_id]
     * @param [type] admin or user
     * @param [searchkeyword] User input title,description and create_user
     * @return [posts]
     */
    public function search($auth_id, $type, $searchkeyword)
    {
        if ($type == 0) {
            if ($searchkeyword == null) {
              $posts = Post::orderBy('updated_at', 'DESC')->paginate(50);
            } else {
                $posts = Post::where('title', 'LIKE', '%' . $searchkeyword . '%')
                  ->orwhere('description', 'LIKE', '%' . $searchkeyword . '%')
                  ->orderBy('updated_at', 'DESC')
                  ->paginate(50);
            }
          } else {
              if ($searchkeyword == null) {
                $posts = Post::where('create_user_id', '=', $auth_id)
                  ->orderBy('updated_at', 'DESC')->paginate(50);
              } else {
                  $posts = Post::where('title', 'LIKE', '%' . $searchkeyword . '%')
                    ->orwhere('description', 'LIKE', '%' . $searchkeyword . '%')
                    ->where('create_user_id', '=', $auth_id)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(50);
              }
          }
          return $posts;
    }

    /**
     * Create Post
     * @param auth user id and input data
     * @return $posts
     */
    public function store($auth_id, $post)
    {
        $insert_post = new Post([
            'title' => $post->title,
            'description' => $post->desc,
            'create_user_id' => $auth_id,
            'updated_user_id' => $auth_id,
        ]);
        $insert_post->save();
        $posts = Post::where('create_user_id', $auth_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(5);
        return $posts;
    }

    /**
     * Edit Post Details
     *
     * @param [post_id] User Click Post
     * @return [psot detail]
     */
    public function edit($post_id)
    {
        $post_detail = Post::find($post_id);
        return $post_detail;
    }

    /**
     * Update Post
     * @param auth user id and input data
     * @return $posts
     */
    public function update($user_id, $post)
    {
        $update_post = Post::find($post->id);
        $update_post->title = $post->title;
        $update_post->description = $post->desc;
        $update_post->status = $post->status;
        $update_post->updated_user_id = $user_id;
        $update_post->updated_at = now();
        $update_post->save();
        $posts = Post::where('create_user_id', $user_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(50);
        return $posts;
    }
}
