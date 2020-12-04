<?php

namespace App\Factories;

use App\Models\Site;

class SiteFactory
{
    /**
     * @return Site
     */
    public static function create(): Site
    {
        return new Site();
    }
}