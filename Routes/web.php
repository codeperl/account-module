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
    Auth::routes();
    Route::group(['middleware' => ['auth']], function() {
        Route::resource('roles','RoleController');
        Route::resource('permissions','PermissionController');
        Route::get('resources','ResourceController@index')->name('resources.index');
        Route::get('resources/generate','ResourceController@generate')->name('resources.generate');

        Route::get('assign-resource-to-permission','AssignResourceToPermissionController@index')->name('assignResourceToPermission.index');
        Route::get('assign-resource-to-permission/form','AssignResourceToPermissionController@form')->name('assignResourceToPermission.form');
        Route::post('assign-resource-to-permission/assign','AssignResourceToPermissionController@assign')->name('assignResourceToPermission.assign');

        Route::get('assign-permission-to-user','AssignPermissionToRoleController@index')->name('assignPermissionToRole.index');
        Route::get('assign-permission-to-user/form','AssignPermissionToUserController@form')->name('assignPermissionToUser.form');
        Route::post('assign-permission-to-user/assign','AssignPermissionToUserController@assign')->name('assignPermissionToUser.assign');

        Route::get('assign-role-to-user','AssignRoleToUserController@index')->name('assignRoleToUser.index');
        Route::get('assign-role-to-user/form','AssignRoleToUserController@form')->name('assignRoleToUser.form');
        Route::post('assign-role-to-user/assign','AssignRoleToUserController@assign')->name('assignRoleToUser.assign');
    });
});
