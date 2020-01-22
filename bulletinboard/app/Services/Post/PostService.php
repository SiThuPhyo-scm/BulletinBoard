<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;

class PostService implements PostServiceInterface
{
    private $postDao;

    /**
     * Class Constructor
     * @param OperatorPostDaoInterface
     * @return
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    /**
     * Get Posts List
     * @param auth user id and user type
     * @return $posts
     */
    public function getPost($auth_id, $type)
    {
        return $this->postDao->getPost($auth_id, $type);
    }

    /**
     * Search Post Detail
     * @param [auth_id]
     * @param [type] Admin or User
     * @param [searchkeyword] user input title,description and create_user
     * @return [postDao] search function
     */
    public function search($auth_id, $type, $searchkeyword)
    {
        return $this->postDao->search($auth_id, $type, $searchkeyword);
    }

    /**
     * Create Post
     * @param auth user id and input data
     * @return $posts
     */
    public function store($auth_id, $post)
    {
        return $this->postDao->store($auth_id, $post);
    }

    /**
     * Edit Post Details
     *
     * @param [post_id] user click post
     * @return $posts
     */
    public function edit($post_id)
    {
        return $this->postDao->edit($post_id);
    }

    /**
     * Update Post
     *
     * @param auth user id and input data
     * @return $post
     */
    public function update($user_id, $post)
    {
        return $this->postDao->update($user_id, $post);
    }

    /**
     * SoftDelete Post
     * @param $auth_id
     * @param $post_id
     * @return $posts
     */
    public function softDelete($auth_id, $post_id)
    {
        return $this->postDao->softDelete($auth_id, $post_id);
    }

}
