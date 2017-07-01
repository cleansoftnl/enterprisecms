<?php namespace WebEd\Modules\Relations\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Modules\Relations';

    protected $moduleAlias = 'webed-relations';

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
            ->registerPermission('View relations', 'view-relations', $this->moduleAlias)
            ->registerPermission('Create relations', 'create-relations', $this->moduleAlias)
            ->registerPermission('Update relations', 'update-relations', $this->moduleAlias)
            ->registerPermission('Delete relations', 'delete-relations', $this->moduleAlias);
            //->registerPermission('View categories', 'view-categories', $this->moduleAlias)
            //->registerPermission('Create categories', 'create-categories', $this->moduleAlias)
            //->registerPermission('Update categories', 'update-categories', $this->moduleAlias)
            //->registerPermission('Delete categories', 'delete-categories', $this->moduleAlias)
            //->registerPermission('View tags', 'view-tags', $this->moduleAlias)
            //->registerPermission('Create tags', 'create-tags', $this->moduleAlias)
            //->registerPermission('Update tags', 'update-tags', $this->moduleAlias)
            //->registerPermission('Delete tags', 'delete-tags', $this->moduleAlias);
    }

    private function createSchema()
    {
        /**
         * Create table relations
         */
        Schema::create('relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('relationname', 100);
            $table->string('slug', 100)->nullable();


            $table->enum('status', ['activated', 'disabled'])->default('activated');


            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });


        /**
         * Tags
         */
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 25);
            $table->string('slug', 25)->nullable();
            $table->enum('status', ['activated', 'disabled'])->default('activated');
            $table->integer('order')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });



        /**
         * Mapper table for relations and relations_tags
         */
        Schema::create('relations_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('relation_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->unique(['relation_id', 'tag_id']);
            $table->foreign('relation_id')->references('id')->on('relations')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });


    }
}
