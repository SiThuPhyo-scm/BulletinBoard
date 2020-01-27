<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * Associated with the UserDao
     */
    private $userDao;

    /**
     * Class Constructor
     *
     * @param UserDaoInterface $userDao
     */
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Get User Detail
     *
     * @return void
     */
    public function getuser()
    {
        return $this->userDao->getuser();
    }

    /**
     * Show User information with modal
     *
     * @param $user_id
     * @return void
     */
    public function show($user_id)
    {
        return $this->userDao->show($user_id);
    }
    /**
     * Search User Details
     *
     * @param $search
     * @return void
     */
    public function search($search)
    {
        return $this->userDao->search($search);
    }

    /**
     * Registration user
     *
     * @param $auth_id
     * @param $user
     * @return void
     */
    public function store($auth_id, $user)
    {
        return $this->userDao->store($auth_id, $user);
    }

    /**
     * Show User Profile
     *
     * @param $auth_id
     * @return void
     */
    public function profile($auth_id)
    {
        return $this->userDao->profile($auth_id);
    }

    /**
     * Edit User Profile
     *
     * @param $auth_id
     * @return void
     */
    public function edit($auth_id)
    {
        return $this->userDao->edit($auth_id);
    }

    /**
     * Update User Profile
     *
     * @param $auth_id
     * @param $user
     * @return void
     */
    public function update($auth_id, $user)
    {
        return $this->userDao->update($auth_id, $user);
    }

    /**
     * Delete User
     *
     * @param $user_id
     * @param $auth_id
     * @return void
     */
    public function softDelete($user_id, $auth_id)
    {
        return $this->userDao->softDelete($user_id, $auth_id);
    }

    /**
     * Change Password
     *
     * @param $oldpwd
     * @param $newpwd
     * @param $auth_id
     * @return void
     */
    public function changepassword($oldpwd, $newpwd, $auth_id)
    {
        return $this->userDao->changepassword($oldpwd, $newpwd, $auth_id);
    }
}
