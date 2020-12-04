<?php

namespace App\Factories;

use App\Models\Provider;

class ProviderFactory
{
    /**
     * @return Provider
     */
    public static function create(): Provider
    {
        return new Provider();
    }
}