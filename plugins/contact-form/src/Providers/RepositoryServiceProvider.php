<?php namespace WebEd\Plugins\ContactForm\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\ContactForm\Models\Contact;
use WebEd\Plugins\ContactForm\Repositories\ContactRepository;
use WebEd\Plugins\ContactForm\Repositories\ContactRepositoryCacheDecorator;
use WebEd\Plugins\ContactForm\Repositories\Contracts\ContactRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\ContactForm';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactRepositoryContract::class, function () {
            $repository = new ContactRepository(new Contact());

            if (config('webed-caching.repository.enabled')) {
                return new ContactRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
