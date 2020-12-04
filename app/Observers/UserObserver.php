<?php

namespace App\Observers;

use App\Helpers\UserHelper;
use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     */
    public function creating(User $user)
    {
        $user->password = UserHelper::hashingPassword($user->password);
    }

    /**
     * @param User $user
     */
    public function updating(User $user)
    {
        if ($user->isDirty('password')) {
            $user->password = UserHelper::hashingPassword($user->password);
        }
    }
}