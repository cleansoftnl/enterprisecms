<?php
namespace WebEd\Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Models\ViewTracker;
use WebEd\Base\Repositories\Contracts\ViewTrackerRepositoryContract;
use WebEd\Base\Repositories\ViewTrackerRepository;
use WebEd\Base\Repositories\ViewTrackerRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Modules\Core';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
