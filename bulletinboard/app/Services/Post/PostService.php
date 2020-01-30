<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;
use App\Models\Post;
use App\Models\User;
use Auth;

class PostService implements PostServiceInterface
{
    /**
     * Associated with the PostDao
     *
     */
    private $postDao;

    /**
     * Class Constructor
     *
     * @param PostDaoInterface $postDao
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    /**
     * Get Posts List
     *
     * @param $auth_id
     * @param $type
     * @return void
     */
    public function getPost()
    {
        session()->forget([
            'search',
            'title',
            'desc'
        ]);
        $auth_id = Auth::user()->id;
        $type = Auth::user()->type;
        $searchkeyword=session('searchkeyword');
        return $this->postDao->getPost($auth_id, $type, $searchkeyword);
    }

    /**
     * Search Post List
     *
     * @param $request
     */
    public function search($request)
    {
        session([
            'searchkeyword' => $request->search
        ]);
        return $this->postDao->getPost($auth_id = Auth::user()->id, $type = Auth::user()->type, $searchkeyword = $request->search);
    }

    /**
     * Show Post Details with modal
     *
     * @param $post_id
     * @return $post
     */
    public function show($post_id)
    {
        $post = $this->postDao->show($post_id);
        $post->create_user_id = $post->createuser->name;
        $post->updated_user_id = $post->updateuser->name;
        if($post->status == 1) {
            $post->status = 'Active';
        }
        else {
            $post->status = 'Inactive';
        }
        return $post;
    }

    /**
     * Show post crete confirmation page
     *
     * @param $request
     * @return $post
     */
    public function createConfirm($request)
    {
        session([
            'title' => $request->title,
            'desc'  => $request->desc
        ]);
        $post    =  new Post;
        $post->title = $request->title;
        $post->desc  = $request->desc;
        return $post;
    }

    /**
     * Store Post Details into the database
     *
     * @param $request
     * @return void
     */
    public function store($request)
    {
        $post    =  new Post;
        $post->title = $request->title;
        $post->desc  = $request->desc;
        return $this->postDao->store($auth_id = Auth::user()->id, $post);
    }

    /**
     * Edit Post Details
     *
     * @param $post_id
     * @return void
     */
    public function edit($post_id)
    {
        session()->forget([
            'searchkeyword'
        ]);
        return $this->postDao->edit($post_id);
    }

    /**
     *
     */
    public function editConfirm($request)
    {
        session([
            'title' => $request->title,
            'desc'  => $request->desc
        ]);
        $post = new Post;
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->status = $request->status;
        if (is_null($post->status)) {
            $post->status = '0';
        }
        return $post;
    }

    /**
     * Update Post
     *
     * @param $request
     * @param $post_id
     * @return void
     */
    public function update($request, $post_id)
    {
        $post     =  new Post;
        $post->id     =  $post_id;
        $post->title  =  $request->title;
        $post->desc   =  $request->desc;
        $post->status   =  $request->status;
        return $this->postDao->update($user_id = Auth::user()->id, $post);
    }

    /**
     * SoftDelete Post
     *
     * @param $auth_id
     * @param $post_id
     * @return void
     */
    public function softDelete($auth_id, $post_id)
    {
        session()->forget([
            'searchkeyword'
        ]);
        return $this->postDao->softDelete($auth_id, $post_id);
    }

    /**
     * Import CSV file
     *
     * @param $auth_id
     * @param $filepath
     * @return void
     */
    public function import($auth_id, $filepath)
    {
        return $this->postDao->import($auth_id, $filepath);
    }

}
