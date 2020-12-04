<?php

namespace App\Helpers;

use App\Models\Template;
use App\Models\TemplateFile;

/**
 * Class TemplateFileHelper
 * @package App\Helpers
 */
class TemplateFileHelper
{
    const LAYOUT_FILE_PATH = 'template'. DIRECTORY_SEPARATOR;

    /**
     * @param $file
     * @return false|string
     */
    public static function storeLayoutFile(Template $template, $file)
    {
        $fileNameLIst = explode(".", $file->getClientOriginalName());
        $name = md5("file" . '-' . date('Y_m_d_h_i_s') . rand(1, 1000));

        if (count($fileNameLIst) == 2) {
            $expansion = $file->getClientOriginalExtension();
            $newFile = \Storage::putFileAs(self::LAYOUT_FILE_PATH . $template->name , $file,$name . "." . $expansion);

        } elseif (count($fileNameLIst) == 3 && $fileNameLIst[2] = "blade"){
            $newFile =\Storage::putFileAs(self::LAYOUT_FILE_PATH . $template->name , $file,$name . ".blade.php" );
        }

        return $newFile;
    }

    /**
     * @param TemplateFile $templateFile
     * @return string
     */
    public static function getFilePath(TemplateFile $templateFile): string
    {
        return storage_path('app'. DIRECTORY_SEPARATOR . $templateFile->file_name);
    }
}
