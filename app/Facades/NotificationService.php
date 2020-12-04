<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class NotificationService
 * @package App\Facades
 */
class NotificationService extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notificationService';
    }
}
