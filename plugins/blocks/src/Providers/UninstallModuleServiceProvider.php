<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\ServiceProvider;

class UninstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blocks';

    protected $moduleAlias = 'webed-blocks';

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

    private function booted()
    {
        acl_permission()
        ->unsetPermissionByModule($this->module);

        $this->dropSchema();
    }

    private function dropSchema()
    {
        \Schema::dropIfExists('blocks');
    }
}
