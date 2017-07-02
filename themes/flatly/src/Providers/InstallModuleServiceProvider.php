<?php namespace WebEd\Themes\Flatly\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Themes\Flatly';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function booted()
    {
        //acl_permission()
        //->registerPermission('Permission 1 description', 'description-1', $this->module)
        //->registerPermission('Permission 2 description', 'description-2', $this->module);
    }
}
