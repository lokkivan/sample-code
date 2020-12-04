<?php

namespace App\Observers;

use App\Models\Template;

/**
 * Class TemplateObserver
 * @package App\Observers
 */
class TemplateObserver
{
    /**
     * @param Template $template
     */
    public function deleted(Template $template): void
    {
        \Storage::deleteDirectory('template' . DIRECTORY_SEPARATOR  . $template->name);
    }
}
