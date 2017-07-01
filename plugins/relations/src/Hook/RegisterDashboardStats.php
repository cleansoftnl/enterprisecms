<?php namespace WebEd\Modules\Relations\Hook;

use WebEd\Modules\Relations\Repositories\CategoryRepository;
use WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;

class RegisterDashboardStats
{
    /**
     * @var RelationRepository
     */
    protected $postRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(RelationsRepositoryContract $postRepository, CategoryRepositoryContract $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function handle()
    {
        echo view('webed-relations::admin.dashboard-stats.stat-box', [
            'postsCount' => $this->postRepository->count(),
            'categoriesCount' => $this->categoryRepository->count(),
        ]);
    }
}
