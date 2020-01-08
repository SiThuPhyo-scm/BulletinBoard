<?php

namespace App\Dao\Post;

use Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post\Post;
use DB;

class PostDao implements PostDaoInterface
{
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
