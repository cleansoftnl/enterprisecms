<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;



/**
 *
 * @var Router $router
 *
 */

//Route::group(['prefix' => 'relations'], function (Router $router) {
    Route::get('', 'RelationsController@getIndex')
        ->name('admin::relations.prospects.index.get');
    //->middleware('has-permission:view-prospects')

    Route::post('', 'RelationsController@prospectListing')
        ->name('admin::relations.prospects.index.prospects')
        ->middleware('has-permission:view-prospects');

    Route::get('create', 'RelationsController@getProspectCreate')
        ->name('admin::relations.prospects.create.get')
        ->middleware('has-permission:create-prospects');

    Route::post('create', 'RelationsController@prospectCreate')
        ->name('admin::relations.prospects.create.prospects')
        ->middleware('has-permission:create-prospects');

    Route::get('edit/{id}', 'RelationsController@getProspectEdit')
        ->name('admin::relations.prospects.edit.get')
        ->middleware('has-permission:view-prospects');

    Route::post('edit/{id}', 'RelationsController@prospectEdit')
        ->name('admin::relations.prospects.edit.prospects')
        ->middleware('has-permission:edit-prospects');

    Route::post('update-status/{id}/{status}', 'RelationsController@prospectUpdateStatus')
        ->name('admin::relations.prospects.update-status.prospects')
        ->middleware('has-permission:edit-prospects');

    Route::delete('{id}', 'RelationsController@prospectDelete')
        ->name('admin::relations.prospects.delete.delete')
        ->middleware('has-permission:delete-prospects');
//});