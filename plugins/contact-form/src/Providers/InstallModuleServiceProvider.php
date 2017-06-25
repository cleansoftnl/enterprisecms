<?php namespace WebEd\Plugins\ContactForm\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\ContactForm';

    protected $moduleAlias = 'webed-contact-form';

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
            ->registerPermission('View contact forms', 'view-contact-forms', $this->moduleAlias)
            ->registerPermission('Update contact forms', 'update-contact-forms', $this->moduleAlias)
            ->registerPermission('Delete contact forms', 'delete-contact-forms', $this->moduleAlias);

        Schema::create('contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('content')->nullable();
            $table->text('options')->nullable();
            $table->enum('status', ['read', 'unread'])->default('unread');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }
}
