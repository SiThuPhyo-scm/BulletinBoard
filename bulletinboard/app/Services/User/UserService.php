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
     * Search User Details
     * @param $name, $email, $datefrom and $dateto
     * @return [userDao] search function
     */
    public function search($name, $email, $datefrom, $dateto)
    {
        return $this->userDao->search($name, $email, $datefrom, $dateto);
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
     * @return [user] information
     */
    public function edit($auth_id)
    {
        return $this->userDao->edit($auth_id);
    }

    /**
     * Update User Profile
     *
     * @param [Request] user input
     * @param [$user_id] auth id
     */
    public function update($auth_id, $user)
    {
        return $this->userDao->update($auth_id, $user);
    }

    /**
     * Delete User
     * @param $auth_id and $user_id
     * @return [user]
     */
    public function softDelete($user_id, $auth_id)
    {
        return $this->userDao->softDelete($user_id, $auth_id);
    }

    /**
     * Change Password
     * @param $oldpassword and $newpassword
     * @param $auth_id
     * @return $status
     */
    public function changepassword($oldpwd, $newpwd, $auth_id)
    {
        return $this->userDao->changepassword($oldpwd, $newpwd, $auth_id);
    }
}
