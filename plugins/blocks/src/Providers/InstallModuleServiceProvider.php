<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
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
        $this->createSchema();

        acl_permission()
            ->registerPermission('View blocks', 'view-blocks', $this->module)
            ->registerPermission('Create blocks', 'create-blocks', $this->module)
            ->registerPermission('Edit blocks', 'edit-blocks', $this->module)
            ->registerPermission('Delete blocks', 'delete-blocks', $this->module);
    }

    private function createSchema()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('page_template', 255)->nullable();
            $table->text('content')->nullable();
            $table->enum('status', ['activated', 'disabled'])->default('activated');
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }
}
