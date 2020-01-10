<?php

namespace App\Dao\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;

class PostDao implements PostDaoInterface
{
    /**
     * Get Posts List
     * @param Object
     * @return $posts
     */
    public function getPost($auth_id, $type)
    {
        if ($type == '0') {
            $posts = Post::orderBy('updated_at', 'DESC')->paginate(5);
        } else {
            $posts = Post::where('create_user_id', $auth_id)
                ->orderBy('updated_at', 'DESC')
                ->paginate(50);
        }
        return $posts;
    }

    /**
     * Create Post
     * @param Object
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
            ->paginate(50);
        return $posts;
    }

    /**
     * Update Post
     * @param Object
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
