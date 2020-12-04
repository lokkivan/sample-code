<?php

namespace App\Helpers;

use Hash;
use App\Models\User;

class UserHelper
{
    /**
     * @param string $password
     *
     * @return string
     */
    public static function hashingPassword($password)
    {
        return Hash::make($password);
    }

    /**
     * @param int $role
     * @return string
     */
    public static function getRoleName($role): string
    {
        switch ($role) {
            case User::ROLE_GUEST:
                return __('user.role_guest');
            case User::ROLE_MANAGER:
                return __('user.role_manager');
            case User::ROLE_ADMIN:
                return __('user.role_admin');
            default:
                return __('user.unknown_role');
        }
    }
}