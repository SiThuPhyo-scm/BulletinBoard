<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;

Class PostService implements PostServiceInterface
{
    private $postDao;

    /**
     * Class Contractor
     * @param OperatorPostDaoInterface
     * @return
     */
    public function __contruct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }
    /**
     * Get Posts List
     * @param Object
     * @return $posts
     */
    public function getPost($auth_id, $type)
    {
        return $this->postDao->getPost($auth_id, $type);
    }
    /**
     * Create Post
     * @param Object
     * @return $posts
     */
    public function store($auth_id, $post)
    {
        return $this->postDao->store($auth_id, $post);
    }
}
