<?php

namespace App\Models;

use App\Repositories\RoleRepository;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    const ROLE_GUEST = 'guest';

    /**
     * @var string
     */
    const ROLE_MANAGER = 'manager';

    /**
     * @var string
     */
    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role',
    ];

    /**
     * @var string
     */
    const EMAIL_VALIDATION_RULE = 'sometimes|required|email|unique:users';

    /**
     * @var string
     */
    const NAME_VALIDATION_RULE = 'string|max:255|nullable';

    /**
     * @var string
     */
    const PASSWORD_VALIDATION_RULE = 'required|string|min:4';

    /**
     * @var string
     */
    const REPEAT_PASSWORD_VALIDATION_RULE = 'required_with:password|same:password|string|min:4';


    /**
     * @var string
     */
    const ROLE_VALIDATION_RULE = 'required|in:';


    /**
     * @return array
     */
    public function validationRules(): array
    {
        if ($this->exists) {
            return [
                'email' => self::EMAIL_VALIDATION_RULE . ',email,' . $this->id,
                'name' => self::NAME_VALIDATION_RULE,
            ];
        }

        return [
            'email' => self::EMAIL_VALIDATION_RULE,
            'name' => self::NAME_VALIDATION_RULE,
            'password' => self::PASSWORD_VALIDATION_RULE,
        ];
    }

    /**
     * @return array
     */
    public function changePasswordValidationRules(): array
    {
        return [
            'password' => self::PASSWORD_VALIDATION_RULE,
            'repeat_password' => self::REPEAT_PASSWORD_VALIDATION_RULE,
        ];
    }

    /**
     * @return array
     */
    public function changeRoleValidationRules(): array
    {
        $repository = new RoleRepository();

        return [
            'role' => self::ROLE_VALIDATION_RULE . implode(',', array_keys($repository->getRoles())),
        ];
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->role === self::ROLE_ADMIN) {
            return true;
        }

        if ($role === self::ROLE_GUEST || $this->role === self::ROLE_MANAGER) {
            return true;
        }

        if ($role === self::ROLE_GUEST ) {
            return true;
        }

        return $this->role === $role;
    }

    /**
     * @return array
     */
    public static function getAvailableRoles()
    {
        return [
            self::ROLE_GUEST,
            self::ROLE_MANAGER,
            self::ROLE_ADMIN,
        ];
    }
}
