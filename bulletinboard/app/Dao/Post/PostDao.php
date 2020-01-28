<?php

namespace App\Dao\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;

class PostDao implements PostDaoInterface
{
    /**
     * Get Posts List
     *
     * @param $auth_id
     * @param $type
     * @return $posts
     */
    public function getPost($auth_id, $type)
    {
        if ($type == '0') {
            $posts = Post::orderBy('updated_at', 'DESC')->paginate(10);
        } else {
            $posts = Post::where('create_user_id', $auth_id)
                ->orderBy('updated_at', 'DESC')
                ->paginate(10);
        }
        return $posts;
    }

    /**
     * Show Post Details with modal
     *
     * @param $post
     * @return $post
     */
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        return $post;
    }

    /**
     * Search Post Details
     *
     * @param $auth_id
     * @param $type
     * @param $searchkeyword
     * @return $posts
     */
    public function search($auth_id, $type, $searchkeyword)
    {
        if ($type == 0) {
            if ($searchkeyword == null) {
                $posts = Post::orderBy('updated_at', 'DESC')->paginate(10);
            } else {
                $posts = Post::where('title', 'LIKE', '%' . $searchkeyword . '%')
                    ->orwhere('description', 'LIKE', '%' . $searchkeyword . '%')
                    ->orwhereHas('user', function ($query) use ($searchkeyword) {
                        $query->where('name', 'LIKE', '%' . $searchkeyword . '%');
                    })
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(10);
            }
        } else {
            if ($searchkeyword == null) {
                $posts = Post::where('create_user_id', $auth_id)
                    ->orderBy('updated_at', 'DESC')->paginate(10);
            } else {
                $posts = Post::where('title', 'LIKE', '%' . $searchkeyword . '%')
                    ->where('create_user_id', $auth_id)
                    ->orwhere('description', 'LIKE', '%' . $searchkeyword . '%')
                    ->where('create_user_id', $auth_id)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(10);
            }
        }
        return $posts;
    }

    /**
     * Store Post Details into the database
     *
     * @param $auth_id
     * @param $post
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
            ->paginate(10);
        return $posts;
    }

    /**
     * Edit Post Details
     *
     * @param $post_id
     * @return $post_detail
     */
    public function edit($post_id)
    {
        $post_detail = Post::find($post_id);
        return $post_detail;
    }

    /**
     * Update Post
     *
     * @param $user_id
     * @param $post
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
            ->paginate(10);
        return $posts;
    }

    /**
     * SoftDelete Post
     *
     * @param $auth_id
     * @param $post_id
     */
    public function softDelete($auth_id, $post_id)
    {
        $delete_post = Post::findOrFail($post_id);
        $delete_post->deleted_user_id = $auth_id;
        $delete_post->deleted_at = now();
        $delete_post->save();
    }

    /**
     * Import CSV file
     *
     * @param $auth_id
     * @param $filepath
     * @return $message
     */
    public function import($auth_id, $filepath)
    {
        if (($handle = fopen($filepath, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE ) {
                $post = new Post;
                $post->title = $data[0];
                $post->description = $data[1];
                $post->create_user_id = $auth_id;
                $post->updated_user_id = $auth_id;
                $import_post = Post::where('title', 'LIKE', '%' . $post->title . '%');
                if ($import_post->count() < 1) {
                    $post->save();
                    $message = '1';
                } else {
                    $message = '0';
                }
            }
            fclose($handle);
        }
        return $message;
    }

}
