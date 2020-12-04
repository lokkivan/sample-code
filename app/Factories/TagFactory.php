<?php

namespace App\Factories;

use App\Models\Tag;

/**
 * Class TagFactory
 * @package App\Factories
 */
class TagFactory
{
    /**
     * @return Tag
     */
    public static function create(): Tag
    {
        return new Tag();
    }
}