<?php

namespace App\Factories;

use App\Models\Thumb;

/**
 * Class ThumbFactory
 * @package App\Factories
 */
class ThumbFactory
{
    /**
     * @return Thumb
     */
    public static function create(): Thumb
    {
        return new Thumb();
    }
}