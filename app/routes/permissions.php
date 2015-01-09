<?php
// Routes for PermissionController
Route::group(['prefix' => 'permissions', 'before' => 'auth'], function()
{
	Route::get('showPermissions', [
		'as' => 'showPermissions_path',
		'uses' => 'PermissionsController@index'
		]);

	Route::get('{permission}/showPermission', [
		'as' => 'showPermission_path',
		'uses' => 'PermissionsController@show'
		]);

	Route::delete('{permission}/deletePermission', [
		'as' => 'deletePermission_path',
		'uses' => 'PermissionsController@destroy'
		]);

	Route::patch('{permission}/updatePermission', [
		'as' => 'updatePermission_path',
		'uses' => 'PermissionsController@update'
		]);

	Route::post('savePermission', [
		'as' => 'savePermission_path',
		'uses' => 'PermissionsController@store'
		]);
});