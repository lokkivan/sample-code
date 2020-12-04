<?php

namespace App\Factories;

use App\Models\LayoutFile;

class LayoutFileFactory
{
    /**
     * @return LayoutFile
     */
    public static function create(): LayoutFile
    {
        return new LayoutFile();
    }
}