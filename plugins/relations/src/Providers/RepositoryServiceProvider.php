<?php
namespace WebEd\Modules\Relations\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Modules\Relations\Models\BlogTag;
use WebEd\Modules\Relations\Models\Category;
use WebEd\Modules\Relations\Models\Relation;
use WebEd\Modules\Relations\Repositories\BlogTagRepository;
use WebEd\Modules\Relations\Repositories\BlogTagRepositoryCacheDecorator;
use WebEd\Modules\Relations\Repositories\CategoryRepository;
use WebEd\Modules\Relations\Repositories\CategoryRepositoryCacheDecorator;
use WebEd\Modules\Relations\Repositories\Contracts\BlogTagRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;
use WebEd\Modules\Relations\Repositories\RelationsRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Modules\Relations';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RelationsRepositoryContract::class, function () {
            $repository = new RelationsRepository(new Relation());

            if (config('webed-caching.repository.enabled')) {
                return new RelationsRepositoryCacheDecorator($repository, WEBED_RELATIONS_GROUP_CACHE_KEY);
            }

            return $repository;
        });
        /*
        $this->app->bind(CategoryRepositoryContract::class, function () {
            $repository = new CategoryRepository(new Category());

            if (config('webed-caching.repository.enabled')) {
                return new CategoryRepositoryCacheDecorator($repository, WEBED_RELATIONS_GROUP_CACHE_KEY);
            }

            return $repository;
        });

        $this->app->bind(BlogTagRepositoryContract::class, function () {
            $repository = new BlogTagRepository(new BlogTag());

            if (config('webed-caching.repository.enabled')) {
                return new BlogTagRepositoryCacheDecorator($repository, WEBED_RELATIONS_GROUP_CACHE_KEY);
            }

            return $repository;
        });
*/
    }
}
