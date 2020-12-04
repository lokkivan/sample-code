<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Models\Layout;
use App\Models\Provider;
use App\Models\Site;
use App\Models\User;
use App\Policies\FeedbackPolicy;
use App\Policies\LayoutPolicy;
use App\Policies\ProviderPolicy;
use App\Policies\SitePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Site::class => SitePolicy::class,
        Provider::class => ProviderPolicy::class,
        Layout::class => LayoutPolicy::class,
        Feedback::class => FeedbackPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
