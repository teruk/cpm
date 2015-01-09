<?php
// Routes for UsersController
Route::group(['prefix' => 'users', 'before' => 'auth'], function()
{
	/** general user routes */
	Route::get('showUsers', [
		'as' => 'showUsers_path',
		'uses' => 'UsersController@index'
		]);

	Route::get('{user}/showUser', [
		'as' => 'showUser_path',
		'uses' => 'UsersController@show'
		]);

	Route::delete('{user}/deleteUser', [
		'as' => 'deleteUser_path',
		'uses' => 'UsersController@destroy'
		]);

	Route::patch('{user}/updateUser', [
		'as' => 'updateUser_path',
		'uses' => 'UsersController@update'
		]);

	Route::post('saveUser', [
		'as' => 'saveUser_path',
		'uses' => 'UsersController@store'
		]);

	Route::patch('{user}/setNewPassword', [
		'as' => 'setUserNewPassword_path',
		'uses' => 'UsersController@setNewPassword'
		]);

	/** user role relationship routes */
	Route::delete('{user}/detachRole', [
		'as' => 'detachRoleUser_path',
		'uses' => 'UsersController@detachRole'
		]);

	Route::patch('{user}/attachRole', [
		'as' => 'attachRoleUser_path',
		'uses' => 'UsersController@attachRole'
		]);

	/** user researchgroup relationship routes */
	Route::delete('{user}/detachResearchgroup', [
		'as' => 'detachResearchgroupUser_path',
		'uses' => 'UsersController@detachResearchgroup'
		]);

	Route::patch('{user}/attachResearchgroup', [
		'as' => 'attachResearchgroupUser_path',
		'uses' => 'UsersController@attachResearchgroup'
		]);

	/** user de-/activation routes */
	Route::patch('{user}/activateUser', [
		'as' => 'activateUser_path',
		'uses' => 'UsersController@active'
		]);

	Route::patch('{user}/deactivateUser', [
		'as' => 'deactivateUser_path',
		'uses' => 'UsersController@deactivate'
		]);
});