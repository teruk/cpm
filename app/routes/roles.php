<?php

// Routes for RolesController
Route::group(['prefix' => 'roles', 'before' => 'auth'], function()
{
	Route::get('/', 'RolesController@index');
	Route::get('/', array('as' => 'roles.index', 'uses' => 'RolesController@index'));
	Route::get('{role}/show', array('as' => 'roles.show', 'uses' => 'RolesController@show'));
	Route::patch('{role}/update', array('as' => 'roles.update', 'uses' => 'RolesController@update'));
	Route::post('save', array('as' => 'roles.store', 'uses' => 'RolesController@store'));
	Route::delete('{role}/delete', array('as' => 'roles.destroy', 'uses' => 'RolesController@destroy'));

	Route::delete('{role}/detach_permission', array('as' => 'roles.detachPermission', 'uses' => 'RolesController@detachPermission'));
	Route::patch('{role}/update_permission', array('as' => 'roles.updatePermission', 'uses' => 'RolesController@updatePermission'));
});