<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');
$systemRoute = config('webed.system_route');

$moduleRoute = 'backup';



Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute) {
    $router->get('/', 'DashboardController@getIndex')
        ->name('admin::dashboard.index.get')
        ->middleware('has-permission:access-dashboard');

    Route::get('/change-language/{slug}', 'DashboardLanguageController@getChangeLanguage')
        ->name('admin::dashboard-language.get');


    Route::get('/change-theme/{slug}', 'DashboardThemeController@getChangeTheme')
        ->name('admin::dashboard-theme.get');



    /**
     * Commands
     */
    $router->get('system/call-composer-dump-autoload', 'SystemCommandController@getCallDumpAutoload')
        ->name('admin::system.commands.composer-dump-autoload.get')
        ->middleware('has-permission:use-system-commands');

    $router->get('system/update-cms', 'SystemCommandController@getUpdateCms')
        ->name('admin::system.commands.update-cms.get')
        ->middleware('has-permission:use-system-commands');
});

//Route::get('{slugNum?}', 'ResolveSlug@index')->where('slugNum', '(.*)');







/**
 * Backups routes
 */
Route::group(['prefix' => $systemRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    /**
     * View backups
     */
    $router->get('', 'BackupController@getIndex')
        ->name('admin::webed-backup.index.get')
        ->middleware('has-permission:view-backups');
    $router->post('', 'BackupController@postListing')
        ->name('admin::webed-backup.index.post')
        ->middleware('has-permission:view-backups');

    /**
     * Create backup
     */
    $router->get('create/{type?}', 'BackupController@getCreate')
        ->name('admin::webed-backup.create.get')
        ->middleware('has-permission:create-backups');

    /**
     * Download backup
     */
    $router->get('download', 'BackupController@getDownload')
        ->name('admin::webed-backup.download.get')
        ->middleware('has-permission:download-backups');

    /**
     * Delete backup
     */
    $router->delete('delete', 'BackupController@deleteDelete')
        ->name('admin::webed-backup.delete.delete')
        ->middleware('has-permission:delete-backups');

    /**
     * Delete all backups
     */
    $router->get('delete-all', 'BackupController@getDeleteAll')
        ->name('admin::webed-backup.delete-all.get')
        ->middleware('has-permission:delete-backups');
});
