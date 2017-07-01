<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'relations'], function (Router $router) {
    $router->get('', 'PostController@getIndex')
        ->name('admin::blog.relations.index.get')
        ->middleware('has-permission:view-relations');

    $router->post('', 'PostController@postListing')
        ->name('admin::blog.relations.index.post')
        ->middleware('has-permission:view-relations');

    $router->get('create', 'PostController@getCreate')
        ->name('admin::blog.relations.create.get')
        ->middleware('has-permission:create-relations');

    $router->post('create', 'PostController@postCreate')
        ->name('admin::blog.relations.create.post')
        ->middleware('has-permission:create-relations');

    $router->get('edit/{id}', 'PostController@getEdit')
        ->name('admin::blog.relations.edit.get')
        ->middleware('has-permission:view-relations');

    $router->post('edit/{id}', 'PostController@postEdit')
        ->name('admin::blog.relations.edit.post')
        ->middleware('has-permission:edit-relations');

    $router->post('update-status/{id}/{status}', 'PostController@postUpdateStatus')
        ->name('admin::blog.relations.update-status.post')
        ->middleware('has-permission:edit-relations');

    $router->delete('{id}', 'PostController@deleteDelete')
        ->name('admin::blog.relations.delete.delete')
        ->middleware('has-permission:delete-relations');
});