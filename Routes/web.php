<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('account')->group(function() {
    Route::get('/', 'AccountController@index');
    // Auth::routes(['verify' => true]);
    Auth::routes();
    Route::group(['middleware' => ['auth', 'acl']], function() {
        Route::resource('roles','RolesController');
        Route::resource('permissions','PermissionsController');
        Route::get('resources','ResourcesController@index')->name('resources.index');
        Route::get('resources/generate','ResourcesController@generate')->name('resources.generate');
        Route::get('resources/{resource}/show','ResourcesController@show')->name('resources.show');
        Route::delete('resources/{resource}/destroy','ResourcesController@destroy')->name('resources.destroy');

        Route::get('assign-resources-to-permissions','AssignResourcesToPermissionsController@index')->name('assignResourcesToPermissions.index');
        Route::get('assign-resources-to-permissions/form','AssignResourcesToPermissionsController@form')->name('assignResourcesToPermissions.form');
        Route::post('assign-resources-to-permissions/assign','AssignResourcesToPermissionsController@assign')->name('assignResourcesToPermissions.assign');
        Route::delete('assign-resources-to-permissions/unassign','AssignResourcesToPermissionsController@unAssign')->name('assignResourcesToPermissions.unassign');

        Route::get('assign-permissions-to-users','AssignPermissionsToUsersController@index')->name('assignPermissionsToUsers.index');
        Route::get('assign-permissions-to-users/form','AssignPermissionsToUsersController@form')->name('assignPermissionsToUsers.form');
        Route::post('assign-permissions-to-users/assign','AssignPermissionsToUsersController@assign')->name('assignPermissionsToUsers.assign');
        Route::delete('assign-permissions-to-users/unassign','AssignPermissionsToUsersController@unAssign')->name('assignPermissionsToUsers.unassign');

        Route::get('assign-roles-to-users','AssignRolesToUsersController@index')->name('assignRolesToUsers.index');
        Route::get('assign-roles-to-users/form','AssignRolesToUsersController@form')->name('assignRolesToUsers.form');
        Route::post('assign-roles-to-users/assign','AssignRolesToUsersController@assign')->name('assignRolesToUsers.assign');
        Route::delete('assign-roles-to-users/unassign','AssignRolesToUsersController@unAssign')->name('assignRolesToUsers.unassign');
    });
});
