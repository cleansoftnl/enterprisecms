<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 *
 * @var Router $router
 *
 */


Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

    Route::get('', 'RelationsController@getIndex')
        ->name('admin::relations.relations.index.get')
        ->middleware('has-permission:view-relations');

    Route::get('listing', 'RelationsController@relationListing')
        ->name('admin::relations.relations.index.relation')
        ->middleware('has-permission:view-relations');

    Route::post('listing', 'RelationsController@relationListing')
        ->name('admin::relations.relations.index.post')
        ->middleware('has-permission:view-relations');

    Route::get('create', 'RelationsController@getCreate')
        ->name('admin::relations.relations.create.get')
        ->middleware('has-permission:create-relations');

    Route::get('edit/{id}', 'RelationsController@getEdit')
        ->name('admin::relations.relations.edit.get')
        ->middleware('has-permission:view-relations');

    Route::post('edit/{id}', 'RelationsController@relationEdit')
        ->name('admin::relations.relations.edit.relation')
        ->middleware('has-permission:edit-relations');



    $router->post('update-status/{id}/{status}', 'RelationsController@relationUpdateStatus')
        ->name('admin::relations.relations.update-status.post')
        ->middleware('has-permission:edit-relations');

    $router->delete('{id}', 'RelationsController@deleteDelete')
        ->name('admin::relations.relations.delete.delete')
        ->middleware('has-permission:delete-relations');






});


