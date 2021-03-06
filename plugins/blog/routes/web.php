<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'blog';

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) {
    require 'web/posts.php';
    require 'web/categories.php';
    require 'web/tags.php';
});

/**
 * Front site routes
 */
Route::get(config('webed-blog.front_url_prefix') . '/{slug}.html', 'Front\ResolveBlogController@handle')
    ->name('front.web.resolve-blog.get');

Route::get(config('webed-blog.front_url_prefix') . '/tag/{slug}.html', 'Front\TagController@handle')
    ->name('front.web.blog.tags.get');