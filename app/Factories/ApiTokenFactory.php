<?php

namespace App\Factories;

use App\Models\ApiToken;

/**
 * Class ApiTokenFactory
 * @package App\Factories
 */
class ApiTokenFactory
{
    /**
     * @return ApiToken
     */
    public static function create(): ApiToken
    {
        return new ApiToken();
    }
}