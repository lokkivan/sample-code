<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository
{
    /**
     * @return array
     */
    public function getRoles()
    {
        return [
            User::ROLE_GUEST => __('user.role_' . User::ROLE_GUEST),
            User::ROLE_MANAGER => __('user.role_' . User::ROLE_MANAGER),
            User::ROLE_ADMIN => __('user.role_' . User::ROLE_ADMIN),
        ];
    }

}