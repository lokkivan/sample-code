<?php

namespace App\Components\SiteTemplate;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Class TemplatesManipulator
 * @package App\Components\SiteTemplate
 */
class TemplatesManipulator
{
    /**
     * @var string
     */
    const PATH = 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'site-template'
        . DIRECTORY_SEPARATOR . 'templates'
    ;

    /**
     * @return array
     */
    public function getTemplatesList()
    {
        $files = scandir($this->getTemplatesPath());

        return $this->filterTemplateFiles($files);
    }

    /**
     * @return string
     */
    public function getTemplatesPath()
    {
        return base_path(static::PATH);
    }

    /**
     * @param array $files
     * @return array
     */
    private function filterTemplateFiles(array $files): array
    {
        $result = [];

        foreach ($files as $file) {
            if ($file === '.') {
                continue;
            }

            if ($file === '..') {
                continue;
            }

            // ONLY BLADE FILES
            if (false === strpos($file, 'blade.php')) {
                continue;
            }

            $result[] = $file;
        }

        return array_combine($result, $result);
    }

    /**
     * @param string $templateName
     * @return string
     * @throws FileNotFoundException
     */
    private function getPathByTemplateName($templateName): string
    {
        $file = $this->getTemplatesPath() . DIRECTORY_SEPARATOR . $templateName;

        if (file_exists($file)) {
            return $file;
        }

        throw new FileNotFoundException();
    }
}
