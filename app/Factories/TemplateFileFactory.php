<?php

namespace App\Factories;

use App\Models\TemplateFile;

class TemplateFileFactory
{
    /**
     * @return TemplateFile
     */
    public static function create(): TemplateFile
    {
        return new TemplateFile();
    }
}