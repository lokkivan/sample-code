<?php

namespace App\Observers;

use App\Factories\SiteCustomValuesFactory;
use App\Helpers\SiteHelper;
use App\Models\Site;

/**
 * Class SiteObserver
 * @package App\Observers
 */
class SiteObserver
{
    /**
     * @param Site $site
     */
    public function deleted(Site $site): void
    {
        SiteHelper::deleteLogo($site);
        SiteHelper::deleteIcon($site);
    }
}
