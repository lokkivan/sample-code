<?php

namespace App\Factories;

use App\Models\Category;

/**
 * Class CategoryFactory
 * @package App\Factories
 */
class CategoryFactory
{
    /**
     * @return Category
     */
    public static function create(): Category
    {
        return new Category();
    }
}