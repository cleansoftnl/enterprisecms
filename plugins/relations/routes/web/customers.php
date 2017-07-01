<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'relations'], function (Router $router) {
    $router->get('', 'RelationsController@getIndex')
        ->name('admin::relations.customers.index.get');
    //->middleware('has-permission:view-customers')

    $router->post('', 'RelationsController@customerListing')
        ->name('admin::relations.customers.index.customers')
        ->middleware('has-permission:view-customers');

    $router->get('create', 'RelationsController@getCustomerCreate')
        ->name('admin::relations.customers.create.get')
        ->middleware('has-permission:create-customers');

    $router->post('create', 'RelationsController@customerCreate')
        ->name('admin::relations.customers.create.customers')
        ->middleware('has-permission:create-customers');

    $router->get('edit/{id}', 'RelationsController@getCustomerEdit')
        ->name('admin::relations.customers.edit.get')
        ->middleware('has-permission:view-customers');

    $router->post('edit/{id}', 'RelationsController@customerEdit')
        ->name('admin::relations.customers.edit.customers')
        ->middleware('has-permission:edit-customers');

    $router->post('update-status/{id}/{status}', 'RelationsController@customerUpdateStatus')
        ->name('admin::relations.customers.update-status.customers')
        ->middleware('has-permission:edit-customers');

    $router->delete('{id}', 'RelationsController@customerDelete')
        ->name('admin::relations.customers.delete.delete')
        ->middleware('has-permission:delete-customers');
});