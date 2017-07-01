<?php
namespace WebEd\Modules\Relations\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;

class UninstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Modules\Relations';

    protected $moduleAlias = 'relations';

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
        acl_permission()
        ->unsetPermissionByModule($this->moduleAlias);

        $this->dropSchema();
    }

    protected function dropSchema()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('relations');

    }
}
