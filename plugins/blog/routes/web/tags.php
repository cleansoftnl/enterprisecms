<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'tags'], function (Router $router) {
    $router->get('', 'RelationTagController@getIndex')
        ->name('admin::blog.tags.index.get')
        ->middleware('has-permission:view-tags');

    $router->post('', 'RelationTagController@postListing')
        ->name('admin::blog.tags.index.post')
        ->middleware('has-permission:view-tags');

    $router->get('create', 'RelationTagController@getCreate')
        ->name('admin::blog.tags.create.get')
        ->middleware('has-permission:create-tags');

    $router->post('create', 'RelationTagController@postCreate')
        ->name('admin::blog.tags.create.post')
        ->middleware('has-permission:create-tags');

    $router->get('edit/{id}', 'RelationTagController@getEdit')
        ->name('admin::blog.tags.edit.get')
        ->middleware('has-permission:view-tags');

    $router->post('edit/{id}', 'RelationTagController@postEdit')
        ->name('admin::blog.tags.edit.post')
        ->middleware('has-permission:edit-tags');

    $router->post('update-status/{id}/{status}', 'RelationTagController@postUpdateStatus')
        ->name('admin::blog.tags.update-status.post')
        ->middleware('has-permission:edit-tags');

    $router->delete('{id}', 'RelationTagController@deleteDelete')
        ->name('admin::blog.tags.delete.delete')
        ->middleware('has-permission:delete-tags');
});