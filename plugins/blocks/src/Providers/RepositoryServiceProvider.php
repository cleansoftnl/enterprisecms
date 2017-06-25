<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blocks\Models\Block;
use WebEd\Plugins\Blocks\Repositories\BlockRepository;
use WebEd\Plugins\Blocks\Repositories\BlockRepositoryCacheDecorator;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blocks';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlockRepositoryContract::class, function () {
            $repository = new BlockRepository(new Block());

            if (config('webed-caching.repository.enabled')) {
                return new BlockRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
