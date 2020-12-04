<?php

namespace App\Factories;

use App\Models\SiteCustomValues;

class SiteCustomValuesFactory
{
    /**
     * @return SiteCustomValues
     */
    public static function create(): SiteCustomValues
    {
        return new SiteCustomValues();
    }
}