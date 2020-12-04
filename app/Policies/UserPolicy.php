<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 * @package App\Policies
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool|null
     */
    public function before(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return true;
        }

        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
       return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function changePassword(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function changeRole(User $user, User $model): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function canSeeErrors(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN);
    }
}
