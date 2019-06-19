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
    // Auth::routes(['verify' => true]);
    Route::get('/', 'AccountController@index');
    Auth::routes();
    Route::group(['middleware' => ['auth', 'acl']], function() {

        Route::get('resources/tab','AccountController@resources')->name('account.resources.tab');
        Route::get('permissions/tab','AccountController@permissions')->name('account.permissions.tab');
        Route::get('assign-resource-to-permission/tab','AccountController@assignResourceToPermission')->name('account.assign-resource-to-permission.tab');
        Route::get('roles/tab','AccountController@roles')->name('account.roles.tab');
        Route::get('assign-role-to-user/tab','AccountController@assignRoleToUser')->name('account.assign-role-to-user.tab');
        Route::get('assign-permission-to-user/tab','AccountController@assignPermissionToUser')->name('account.assign-permission-to-user.tab');
        Route::post('resources/tab/generate','AccountController@resourcesGenerate')->name('account.resources.generate');

        Route::post('permissions/tab/store','AccountController@permissionsStore')->name('account.permissions.store');
        Route::post('assign-resources-to-permissions/tab/assign','AccountController@resourcesToPermissionsAssign')->name('account.assignResourcesToPermissions.assign');
        Route::post('roles/tab/store','AccountController@rolesStore')->name('account.roles.store');
        Route::post('assign-roles-to-users/tab/assign','AccountController@rolesToUsersAssign')->name('account.assignRolesToUsers.assign');
        Route::post('assign-permissions-to-users/tab/assign','AccountController@permissionsToUsersAssign')->name('account.assignPermissionsToUsers.assign');

        Route::get('resources/tab/{resource}/show','AccountController@resourceShow')->name('account.resources.show');
        Route::get('permissions/tab/{permission}/show','AccountController@permissionShow')->name('account.permissions.show');
        Route::get('roles/tab/{role}/show','AccountController@roleShow')->name('account.roles.show');

        Route::get('permissions/tab/{permission}/edit','AccountController@permissionEdit')->name('account.permissions.edit');
        Route::match(['put', 'patch'], 'permissions/tab/{id}','AccountController@permissionUpdate')->name('account.permissions.update');

        Route::get('roles/tab/{id}/edit','AccountController@roleEdit')->name('account.roles.edit');
        Route::match(['put', 'patch'], 'roles/tab/{id}','AccountController@roleUpdate')->name('account.roles.update');

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
