<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'relations'], function (Router $router) {
    $router->get('', 'RelationsController@getIndex')
        ->name('admin::relations.suspects.index.get');
    //->middleware('has-permission:view-suspects')

    $router->post('', 'RelationsController@suspectListing')
        ->name('admin::relations.suspects.index.suspects')
        ->middleware('has-permission:view-suspects');

    $router->get('create', 'RelationsController@getSuspectCreate')
        ->name('admin::relations.suspects.create.get')
        ->middleware('has-permission:create-suspects');

    $router->post('create', 'RelationsController@suspectCreate')
        ->name('admin::relations.suspects.create.suspects')
        ->middleware('has-permission:create-suspects');

    $router->get('edit/{id}', 'RelationsController@getSuspectEdit')
        ->name('admin::relations.suspects.edit.get')
        ->middleware('has-permission:view-suspects');

    $router->post('edit/{id}', 'RelationsController@suspectEdit')
        ->name('admin::relations.suspects.edit.suspects')
        ->middleware('has-permission:edit-suspects');

    $router->post('update-status/{id}/{status}', 'RelationsController@suspectUpdateStatus')
        ->name('admin::relations.suspects.update-status.suspects')
        ->middleware('has-permission:edit-suspects');

    $router->delete('{id}', 'RelationsController@suspectDelete')
        ->name('admin::relations.suspects.delete.delete')
        ->middleware('has-permission:delete-suspects');
});