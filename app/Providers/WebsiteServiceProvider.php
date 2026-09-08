<?php

namespace Modules\Website\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class WebsiteServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Website';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'website';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();

        \Illuminate\Support\Facades\View::composer(['website::*', 'layouts.web', 'layouts.public'], function ($view) {
            if (\Illuminate\Support\Facades\Schema::hasTable('website_settings')) {
                $settings = \Illuminate\Support\Facades\Cache::remember('website_settings_all', 3600, function () {
                    return \Modules\Website\Models\WebsiteSetting::pluck('value', 'key')->all();
                });
                $view->with('settings', $settings);
            }
        });
    }
}
