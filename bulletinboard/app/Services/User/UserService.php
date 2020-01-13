<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private $userDao;

    /**
     * Class Constructor
     * @param OperatorUserDaoInterface
     * @return
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Get User Detail
     *
     * @return $users user detail
     */
    public function getuser()
    {
        return $this->userDao->getuser();
    }

    /**
     * Registration user
     * @param $auth_id, $users
     * @return $users
     */
    public function store($auth_id, $user)
    {
        return $this->userDao->store($auth_id, $user);
    }

    /**
     * Show auth_user information
     *
     * @param [auth_id] login user id
     * @return [user] information where auth_id
     */
    public function profile($auth_id)
    {
        return $this->userDao->profile($auth_id);
    }

    /**
     * Edit auth_user information
     *
     * @param [auth_id] login user id
     *
     * @return [user] information
     */
    public function edit($auth_id)
    {
        return $this->userDao->edit($auth_id);
    }
}
