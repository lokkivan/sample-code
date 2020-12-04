<?php

namespace App\Helpers;

use App\Models\Layout;
use App\Models\LayoutFile;

/**
 * Class LayoutFileHelper
 * @package App\Helpers
 */
class LayoutFileHelper
{
    /**
     * @param $file_name
     * @return string
     */
    public static function getFileType($file_name): string
    {
        $parsFileName = explode(".", $file_name);

        return $parsFileName;
    }

    /**
     * @param TemplateFile $templateFile
     * @return string
     */
    public static function getFilePath(LayoutFile $layoutFile): string
    {
        return storage_path('app'. DIRECTORY_SEPARATOR . $layoutFile->file_name);
    }
}
