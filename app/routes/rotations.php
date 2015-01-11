<?php

// Routes for RotationsController
Route::group(['prefix' => 'rotations', 'before' => 'auth'], function()
{
	Route::get('showRotations', [
		'as' => 'showRotations_path',
		'uses' => 'RotationsController@index'
		]);

	Route::get('{rotation}/editRotationInformation', [
		'as' => 'editRotationInformation_path',
		'uses' => 'RotationsController@edit'
		]);

	Route::delete('{rotation}/deleteRotation', [
		'as' => 'deleteRotation_path',
		'uses' => 'RotationsController@destroy'
		]);

	Route::patch('{rotation}/updateRotation', [
		'as' => 'updateRotation_path',
		'uses' => 'RotationsController@update'
		]);

	Route::post('saveRotation', [
		'as' => 'saveRotation_path',
		'uses' => 'RotationsController@store'
		]);
});