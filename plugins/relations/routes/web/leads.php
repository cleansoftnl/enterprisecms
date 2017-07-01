<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'relations'], function (Router $router) {
    $router->get('', 'RelationsController@getIndex')
        ->name('admin::relations.leads.index.get');
    //->middleware('has-permission:view-leads')

    $router->post('', 'RelationsController@leadListing')
        ->name('admin::relations.leads.index.leads')
        ->middleware('has-permission:view-leads');

    $router->get('create', 'RelationsController@getLeadCreate')
        ->name('admin::relations.leads.create.get')
        ->middleware('has-permission:create-leads');

    $router->post('create', 'RelationsController@leadCreate')
        ->name('admin::relations.leads.create.leads')
        ->middleware('has-permission:create-leads');

    $router->get('edit/{id}', 'RelationsController@getLeadEdit')
        ->name('admin::relations.leads.edit.get')
        ->middleware('has-permission:view-leads');

    $router->post('edit/{id}', 'RelationsController@leadEdit')
        ->name('admin::relations.leads.edit.leads')
        ->middleware('has-permission:edit-leads');

    $router->post('update-status/{id}/{status}', 'RelationsController@leadUpdateStatus')
        ->name('admin::relations.leads.update-status.leads')
        ->middleware('has-permission:edit-leads');

    $router->delete('{id}', 'RelationsController@leadDelete')
        ->name('admin::relations.leads.delete.delete')
        ->middleware('has-permission:delete-leads');
});