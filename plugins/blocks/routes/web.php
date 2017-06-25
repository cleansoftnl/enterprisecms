<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */
$adminRoute = config('webed.admin_route');

$moduleRoute = 'blocks';

Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('/', 'BlockController@getIndex')
        ->name('admin::blocks.index.get')
        ->middleware('has-permission:view-blocks');

    $router->post('/', 'BlockController@postListing')
        ->name('admin::blocks.index.post')
        ->middleware('has-permission:view-blocks');

    $router->post('update-status/{id}/{status}', 'BlockController@postUpdateStatus')
        ->name('admin::blocks.update-status.post')
        ->middleware('has-permission:edit-blocks');

    $router->get('create', 'BlockController@getCreate')
        ->name('admin::blocks.create.get')
        ->middleware('has-permission:create-blocks');

    $router->post('create', 'BlockController@postCreate')
        ->name('admin::blocks.create.post')
        ->middleware('has-permission:create-blocks');

    $router->get('edit/{id}', 'BlockController@getEdit')
        ->name('admin::blocks.edit.get')
        ->middleware('has-permission:view-blocks');

    $router->post('edit/{id}', 'BlockController@postEdit')
        ->name('admin::blocks.edit.post')
        ->middleware('has-permission:edit-blocks');

    $router->delete('/{id}', 'BlockController@deleteDelete')
        ->name('admin::blocks.delete.delete')
        ->middleware('has-permission:delete-blocks');
});
