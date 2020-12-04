<?php

namespace App\Factories;

use App\Models\User;

/**
 * Class UserFactory
 * @package App\Factories
 */
class UserFactory
{
    /**
     * @return User
     */
    public static function create(): User
    {
        return new User();
    }
}
