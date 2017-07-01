<?php
namespace WebEd\Modules\Relations\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Modules\Relations\Models\Category;
use WebEd\Modules\Relations\Repositories\RelationsTagRepository;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsTagRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;

class TagController extends BaseFrontController
{
    /**
     * @var RelationsTagRepository
     */
    protected $repository;

    /**
     * @var RelationRepository
     */
    protected $postRepository;

    /**
     * @param RelationRepository $postRepository
     */
    public function __construct(
        RelationsTagRepositoryContract $repository,
        RelationsRepositoryContract $postRepository
    )
    {
        parent::__construct();

        $this->themeController = themes_management()->getThemeController('Relations\Tag');

        if (!$this->themeController) {
            echo 'You need to active a theme';
            die();
        }

        if (is_string($this->themeController)) {
            echo 'Class ' . $this->themeController . ' not exists';
            die();
        }

        $this->repository = $repository;

        $this->postRepository = $postRepository;
    }

    /**
     * @param Category $item
     * @return mixed
     */
    public function handle($slug)
    {
        $item = $this->repository
            ->findWhere([
                'slug' => $slug,
                'status' => 'activated'
            ]);

        if (!$item) {
            abort(\Constants::NOT_FOUND_CODE);
        }

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

        increase_view_count($item, $item->id);

        return $this->themeController->handle($item, $this->dis);
    }
}
