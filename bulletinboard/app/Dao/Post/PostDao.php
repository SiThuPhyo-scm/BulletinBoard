<?php

namespace App\Dao\Post;

use Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;
use DB;

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
        $posts = Post::orderBy('updated_at', 'DESC')->paginate(50);
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
        'title'           =>  $post->title,
        'description'     =>  $post->desc,
        'create_user_id'  =>  $auth_id,
        'updated_user_id' =>  $auth_id
        ]);
        $insert_post->save();
        $posts = Post::where('create_user_id', $auth_id)
        ->orderBy('updated_at', 'DESC')
        ->paginate(50);
        return $posts;
    }
}
