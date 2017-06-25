<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */
$adminRoute = config('webed.admin_route');

$moduleRoute = 'contact-forms';

Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('', 'ContactController@getIndex')
        ->name('admin::contact-forms.index.get')
        ->middleware('has-permission:view-contact-forms');

    $router->post('', 'ContactController@postListing')
        ->name('admin::contact-forms.index.post')
        ->middleware('has-permission:view-contact-forms');

    $router->get('edit/{id}', 'ContactController@getEdit')
        ->name('admin::contact-forms.edit.get')
        ->middleware('has-permission:view-contact-forms');

    $router->post('edit/{id}', 'ContactController@postEdit')
        ->name('admin::contact-forms.edit.post')
        ->middleware('has-permission:edit-contact-forms');

    $router->delete('{id}', 'ContactController@deleteDelete')
        ->name('admin::contact-forms.delete.delete')
        ->middleware('has-permission:delete-contact-forms');
});

Route::post('contact-forms/send', 'Front\ContactController@postCreate')
    ->name('front::contact-forms.create.post');