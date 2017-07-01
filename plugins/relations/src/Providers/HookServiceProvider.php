<?php
namespace WebEd\Modules\Relations\Providers;

use Illuminate\Support\ServiceProvider;
//use WebEd\Modules\Relations\Hook\CustomFields\RenderCustomFields;
use WebEd\Modules\Relations\Hook\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(WEBED_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 25);

        add_action(BASE_ACTION_META_BOXES, [RenderCustomFields::class, 'handle'], 70);
    }

    /**
     * Register any application services.s
     *
     * @return void
     */
    public function register()
    {

    }
}
