<?php

use WebEd\Modules\Relations\Models\Category;

if (!function_exists('get_category_link')) {
    /**
     * @param Category $category
     * @return string
     */
    function get_category_link($category)
    {
        $slug = is_string($category) ? $category : $category->slug;
        return route('front.web.resolve-blog.get', ['slug' => $slug]);
    }
}

if (!function_exists('get_categories')) {
    /**
     * @param array $args
     * @param string $indent
     * @return array|mixed
     */
    function get_categories(array $args = [])
    {
        $indent = array_get($args, 'indent', '——');

        /**
         * @var \WebEd\Modules\Relations\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo->getCategories(array_get($args, 'select', ['*']), [
            'order' => 'ASC',
            'created_at' => 'DESC'
        ]);
        $categories = sort_item_with_children($categories);

        foreach ($categories as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $categories;
    }
}

if (!function_exists('get_categories_with_children')) {
    /**
     * @return array
     */
    function get_categories_with_children()
    {
        /**
         * @var \WebEd\Modules\Relations\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo->get();

        /**
         * @var \WebEd\Base\Support\SortItemsWithChildrenHelper $sortHelper
         */
        $sortHelper = app(\WebEd\Base\Support\SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($categories);

        return $sortHelper->sort();
    }
}
