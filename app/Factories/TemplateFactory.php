<?php

namespace App\Factories;

use App\Models\Template;

class TemplateFactory
{
    /**
     * @return Template
     */
    public static function create(): Template
    {
        return new Template();
    }
}