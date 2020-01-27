<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;

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
    public function getPost($auth_id, $type)
    {
        return $this->postDao->getPost($auth_id, $type);
    }

    /**
     * Show Post Details with modal
     *
     * @param $post_id
     * @return $post
     */
    public function show($post_id)
    {
        $post= $this->postDao->show($post_id);
        if($post->status == 1) {
            $post->status = 'Active';
        }
        else {
            $post->status = 'Inactive';
        }
        return $post;
    }
    /**
     * Search Post Details
     *
     * @param $auth_id
     * @param $type
     * @param $searchkeyword
     * @return void
     */
    public function search($auth_id, $type, $searchkeyword)
    {
        return $this->postDao->search($auth_id, $type, $searchkeyword);
    }

    /**
     * Store Post Details into the database
     *
     * @param $auth_id
     * @param $post
     * @return void
     */
    public function store($auth_id, $post)
    {
        return $this->postDao->store($auth_id, $post);
    }

    /**
     * Edit Post Details
     *
     * @param $post_id
     * @return void
     */
    public function edit($post_id)
    {
        return $this->postDao->edit($post_id);
    }

    /**
     * Update Post
     *
     * @param $user_id
     * @param $post
     * @return void
     */
    public function update($user_id, $post)
    {
        return $this->postDao->update($user_id, $post);
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
