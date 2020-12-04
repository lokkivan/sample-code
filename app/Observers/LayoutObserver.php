<?php

namespace App\Observers;

use App\Models\Layout;

/**
 * Class LayoutObserver
 * @package App\Observers
 */
class LayoutObserver
{
    /**
     * @param Layout $layout
     */
    public function deleted(Layout $layout)
    {
        \Storage::deleteDirectory('layout' . DIRECTORY_SEPARATOR  . $layout->name);
    }
}
