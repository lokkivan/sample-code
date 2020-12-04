<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * @param false $asList
     * @return mixed
     */
    public function findAll($asList = false)
    {
        return $asList ? User::pluck('name', 'id')->toArray() : User::all();
    }

    /**
     * @param $id
     * @return User|null
     */
    public function findById($id): ?User
    {
        return User::whereId($id)->first();
    }

    /**
     * @param $email
     * @return User|null
     */
    public function findByEmail($email): ?User
    {
        return User::whereEmail($email)->first();
    }
}
