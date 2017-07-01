<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

$adminRoute = config('webed.admin_route');

$moduleRoute = 'relations';

Route::get('', 'RelationsController@getIndex')
    ->name('admin::relations.relations.index.get');
//->middleware('has-permission:view-relations')



//require 'web/prospects.php';

/**
 *
 * Put some routes here
 *
 */
/*require 'web/relations.php';
require 'web/suspects.php';

require 'web/leads.php';
require 'web/customers.php';*/


/**
 * Admin routes
//use ($adminRoute, $moduleRoute)
 */
/*Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) {
    /**
     *
     * Put some routes here
     *
     *  /
    /*require 'web/relations.php';
    require 'web/suspects.php';
    require 'web/prospects.php';
    require 'web/leads.php';
    require 'web/customers.php';*   /

    /*$router->get('', 'RelationsController@getIndex')
        ->name('admin::relations.relations.index.get');
    //->middleware('has-permission:view-relations')*    /

    $router->get('create', 'RelationsController@getCreate')
        ->name('admin::my.create.get')
        ->middleware('has-permission:create-relations');







    $router->get('', 'RelationsController@getIndex')
        ->name('admin::relations.suspects.index.get');
    //->middleware('has-permission:view-suspects')

    $router->post('', 'RelationsController@suspectListing')
        ->name('admin::relations.suspects.index.suspects')
        ->middleware('has-permission:view-suspects');

    $router->get('create', 'RelationsController@getSuspectCreate')
        ->name('webed-relations::relations.suspects.create.get')
        ->middleware('has-permission:create-suspects');



});*/
require 'web/relations.php';

/*Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

});*/












/**
 * Front site routes
 */
Route::get(config('webed-relations.front_url_prefix') . '/{slug}.html', 'Front\ResolveRelationController@handle')
    ->name('front.web.resolve-relation.get');

Route::get(config('webed-relations.front_url_prefix') . '/tag/{slug}.html', 'Front\TagController@handle')
    ->name('front.web.blog.tags.get');