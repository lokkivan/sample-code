<?php

namespace App\Factories;

use App\Models\Layout;

class LayoutFactory
{
    /**
     * @return Layout
     */
    public static function create(): Layout
    {
        return new Layout();
    }
}