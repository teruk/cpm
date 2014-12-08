<?php
// Routes for PermissionController
Route::group(['prefix' => 'permissions', 'before' => 'auth'], function()
{
	Route::get('/', 'PermissionsController@index');
	Route::get('/', array('as' => 'permissions.index', 'uses' => 'PermissionsController@index'));
	Route::get('{permission}/show', array('as' => 'permissions.show', 'uses' => 'PermissionsController@show'));
	Route::patch('{permission}/update', array('as' => 'permissions.update', 'uses' => 'PermissionsController@update'));
	Route::post('save', array('as' => 'permissions.store', 'uses' => 'PermissionsController@store'));
	Route::delete('{permission}/delete', array('as' => 'permissions.destroy', 'uses' => 'PermissionsController@destroy'));
});