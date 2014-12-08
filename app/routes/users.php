<?php
// Routes for UsersController
Route::group(['prefix' => 'users', 'before' => 'auth'], function()
{
	Route::get('/', 'UsersController@index');
	Route::get('/', array('as' => 'users.index', 'uses' => 'UsersController@index'));
	Route::get('{user}/show', array('as' => 'users.show', 'uses' => 'UsersController@show'));

	Route::delete('{user}/delete', array('as' => 'users.destroy', 'uses' => 'UsersController@destroy'));
	Route::patch('{user}/update', array('as' => 'users.update', 'uses' => 'UsersController@update'));
	Route::patch('{user}/set_new_password', array('as' => 'users.setNewPassword', 'uses' => 'UsersController@setNewPassword'));
	Route::post('save', array('as' => 'users.store', 'uses' => 'UsersController@store'));

	Route::delete('{user}/detach_role', array('as' => 'users.detachRole', 'uses' => 'UsersController@detachRole'));
	Route::patch('{user}/attach_role', array('as' => 'users.attachRole', 'uses' => 'UsersController@attachRole'));

	Route::delete('{user}/detach_researchgroup', array('as' => 'users.detachResearchGroup', 'uses' => 'UsersController@detachResearchGroup'));
	Route::patch('{user}/attach_researchgroup', array('as' => 'users.attachResearchGroup', 'uses' => 'UsersController@attachResearchGroup'));

	Route::patch('{user}/activate', array('as' => 'users.activate', 'uses' => 'UsersController@activate'));
	Route::patch('{user}/deactivate', array('as' => 'users.deactivate', 'uses' => 'UsersController@deactivate'));
});