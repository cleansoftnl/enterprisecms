<?php
namespace WebEd\Modules\Relations\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Modules\Relations\Repositories\CategoryRepository;
use WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;

class ResolveRelationController extends BaseFrontController
{
    /**
     * @var RelationRepositoryContract|RelationRepository
     */
    protected $repository;

    /**
     * @var RelationRepositoryContract|RelationRepository
     */
    protected $categoryRepository;

    /**
     * @param RelationRepositoryContract|RelationRepository $repository
     * @param CategoryRepositoryContract|CategoryRepository $categoryRepositoryContract
     */
    public function __construct(
        RelationsRepositoryContract $repository,
        CategoryRepositoryContract $categoryRepositoryContract
    )
    {
        parent::__construct();

        $this->repository = $repository;

        $this->categoryRepository = $categoryRepositoryContract;
    }

    /**
     * First, we will find the post match this slug. If not exists, we will find the category match this slug.
     * @param $slug
     * @return mixed
     */
    public function handle($slug)
    {
        $item = $this->repository
            ->findWhere([
                'slug' => $slug,
                'status' => 'activated',
            ]);

        if ($item) {
            $item = do_filter(WEBED_RELATIONS_FRONT_POSTS, $item);

            increase_view_count($item, $item->id);

            admin_bar()->registerLink('Edit this post', route('admin::blog.relations.edit.get', ['id' => $item->id]));

            $themeController = themes_management()->getThemeController('Blog\Post');

            if (is_string($themeController)) {
                abort(\Constants::ERROR_CODE, $themeController . ' not exists');
            }

            $this->dis['categoryIds'] = $this->repository->getRelatedCategoryIds($item);

            $this->dis['author'] = $item->author;

            seo()
                ->metaDescription($item->description)
                ->metaImage($item->thumbnail)
                ->metaKeywords($item->keywords)
                ->setModelObject($item);

            $this->themeController = $themeController;
        } else {
            $item = $this->categoryRepository
                ->findWhere([
                    'slug' => $slug,
                    'status' => 'activated',
                ]);

            if ($item) {
                $item = do_filter(WEBED_RELATIONS_FRONT_CATEGORIES, $item);

                increase_view_count($item, $item->id);

                admin_bar()->registerLink('Edit this category', route('admin::blog.categories.edit.get', ['id' => $item->id]));

                $themeController = themes_management()->getThemeController('Blog\Category');

                if (is_string($themeController)) {
                    abort(\Constants::ERROR_CODE, $themeController . ' not exists');
                }

                $this->dis['allRelatedCategoryIds'] = array_unique(array_merge($this->categoryRepository->getAllRelatedChildrenIds($item), [$item->id]));

                seo()
                    ->metaDescription($item->description)
                    ->metaImage($item->thumbnail)
                    ->metaKeywords($item->keywords)
                    ->setModelObject($item);

                $this->themeController = $themeController;
            }
        }
        if (!$item) {
            abort(\Constants::NOT_FOUND_CODE);
        }

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

        return $this->themeController->handle($item, $this->dis);
    }
}
