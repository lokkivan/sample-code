<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NotificationServiceProvider
 * @package App\Providers
 */
class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('notificationService', 'App\Services\Notification');
    }
}