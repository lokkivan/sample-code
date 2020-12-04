<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class NotificationServiceProvider
 * @package App\Providers
 */
class RsaEncryptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('rsaEncryption', 'App\Services\RsaEncryption');
    }
}