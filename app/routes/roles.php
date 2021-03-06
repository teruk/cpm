<?php

// Routes for RolesController
Route::group(['prefix' => 'roles', 'before' => 'auth'], function()
{
	Route::get('showRoles', [
		'as' => 'showRoles_path',
		'uses' => 'RolesController@index'
		]);

	Route::get('{role}/editRoleInformation', [
		'as' => 'editRoleInformation_path',
		'uses' => 'RolesController@edit'
		]);

	Route::get('{role}/showRolePermissions', [
		'as' => 'showRolePermissions_path',
		'uses' => 'RolesController@showPermissions'
		]);

	Route::get('{role}/showRoleUsers', [
		'as' => 'showRoleUsers_path',
		'uses' => 'RolesController@showUsers'
		]);

	Route::delete('{role}/deleteRole', [
		'as' => 'deleteRole_path',
		'uses' => 'RolesController@destroy'
		]);

	Route::patch('{role}/updateRole', [
		'as' => 'updateRole_path',
		'uses' => 'RolesController@update'
		]);

	Route::post('saveRole', [
		'as' => 'saveRole_path',
		'uses' => 'RolesController@store'
		]);

	/** roles permission relationship routes */
	Route::patch('{role}/updatePermission', [
		'as' => 'updatePermission_path',
		'uses' => 'RolesController@updatePermission'
		]);
});
