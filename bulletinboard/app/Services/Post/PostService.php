<?php

namespace App\Services\Post;

use Contracts\Dao\Post\PostDaoInterface;
use Contracts\Services\Post\PostServiceInterface;

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
}
