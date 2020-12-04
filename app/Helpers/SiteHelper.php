<?php

namespace App\Helpers;

use App\Models\Site;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;
use Log;
use Storage;

/**
 * Class SiteHelper
 * @package App\Helpers
 */
class SiteHelper
{
    /**
     * @var string
     */
    const LOGO_PATH = 'uploads'. DIRECTORY_SEPARATOR;

    /**
     * @var int
     */
    const LOGO_WIDTH = 160;

    /**
     * @var int
     */
    const LOGO_HEIGHT = 110;

    /**
     * @var string
     */
    const ICON_PATH = 'uploads'. DIRECTORY_SEPARATOR;

    /**
     * @var int
     */
    const ICON_WIDTH = 32;

    /**
     * @var int
     */
    const ICON_HEIGHT = 32;

    /**
     * @param $file
     * @return string
     */
    public static function storeLogo(UploadedFile $file): string
    {
        $fileName = $file->getFilename();
        $logoName = md5($fileName . '-' . date('Y_m_d_h_i_s')) . '.' . $file->getExtension();
        $logoFullPath = $file->store($logoName, 'public');

        try {
            $image = Image::make(Storage::disk('public')->get($logoFullPath))
                ->resize(self::LOGO_WIDTH, self::LOGO_HEIGHT)
                ->stream()
            ;
            Storage::disk('public')->put($logoFullPath, $image);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
        }

        return $logoFullPath;
    }

    /**
     * @param Site $site
     * @return null|string
     */
    public static function getLogoPath($siteLogo): ?string
    {
        if ($siteLogo) {
            return self::LOGO_PATH . $siteLogo;
        }

        return null;
    }

    /**
     * @param Site $site
     */
    public static function deleteLogo(Site $site): void
    {
        if (Storage::disk('public')->exists($site->logo)) {
            $path = explode('/', $site->logo);
            Storage::disk('public')->delete($site->logo);
            Storage::disk('public')->deleteDirectory($path[0]);
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public static function storeIcon(UploadedFile $file): string
    {
        $fileName = $file->getFilename();
        $iconName = md5($fileName . '-' . date('Y_m_d_h_i_s'). rand(1,1000)) . '.' . $file->getExtension();
        $iconFullPath = $file->store($iconName, 'public');

        try {
            $image = Image::make(Storage::disk('public')->get($iconFullPath))
                ->resize(self::ICON_WIDTH, self::ICON_HEIGHT)
                ->stream()
            ;
            Storage::disk('public')->put($iconFullPath, $image);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [__METHOD__, __CLASS__]);
        }

        return $iconFullPath;
    }

    /**
     * @param $siteIcon
     * @return string|null
     */
    public static function getIconPath($siteIcon): ?string
    {
        if ($siteIcon) {
            return self::ICON_PATH . $siteIcon;
        }

        return null;
    }

    /**
     * @param Site $site
     */
    public static function deleteIcon(Site $site): void
    {
        if (Storage::disk('public')->exists($site->icon)) {
            $path = explode('/', $site->icon);
            Storage::disk('public')->delete($site->icon);
            Storage::disk('public')->deleteDirectory($path[0]);
        }
    }
}
