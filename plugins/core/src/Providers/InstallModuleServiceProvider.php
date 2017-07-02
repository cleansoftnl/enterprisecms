<?php namespace WebEd\Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Modules\Core';

    protected $moduleAlias = 'webed-core';

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
            ->registerPermission('Access to dashboard', 'access-dashboard', $this->module)
            ->registerPermission('System commands', 'use-system-commands', $this->module)
            ->registerPermission('View backups', 'view-backups', $this->moduleAlias)
            ->registerPermission('Download backups', 'download-backups', $this->moduleAlias)
            ->registerPermission('Create backups', 'create-backups', $this->moduleAlias)
            ->registerPermission('Delete backups', 'delete-backups', $this->moduleAlias);
    }
}
