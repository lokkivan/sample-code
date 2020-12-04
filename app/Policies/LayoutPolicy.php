<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class LayoutPolicy
 * @package App\Policies
 */
class LayoutPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool|null
     */
    public function before(User $user): ?bool
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
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function show(User $user): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return false;
    }
}
