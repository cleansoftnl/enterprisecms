<?php

use WebEd\Modules\Relations\Models\Relation;
use \WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;

if (!function_exists('get_post_link')) {
    /**
     * @param Relation $post
     * @return string
     */
    function get_post_link($post)
    {
        $slug = is_string($post) ? $post : $post->slug;
        return route('front.web.resolve-blog.get', ['slug' => $slug]);
    }
}

if (!function_exists('get_posts_by_category')) {
    /**
     * @param array|int $categoryIds
     * @param array $params
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    function get_posts_by_category($categoryIds, array $params = [])
    {
        /**
         * @var \WebEd\Modules\Relations\Repositories\RelationRepository $postRepo
         */
        $postRepo = app(RelationsRepositoryContract::class);

        return $postRepo->getPostsByCategory($categoryIds, $params);
    }
}

if (!function_exists('get_posts_by_tag')) {
    /**
     * @param array|int $categoryIds
     * @param array $params
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    function get_posts_by_tag($tagIds, array $params = [])
    {
        /**
         * @var \WebEd\Modules\Relations\Repositories\RelationRepository $postRepo
         */
        $postRepo = app(RelationsRepositoryContract::class);

        return $postRepo->getPostsByTag($tagIds, $params);
    }
}

if (!function_exists('get_posts')) {
    /**
     * @param mixed
     */
    function get_posts(array $params = [])
    {
        return app(RelationsRepositoryContract::class)->getPosts($params);
    }
}
