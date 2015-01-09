<?php

// Routes for DegreesController
Route::group(['prefix' => 'degrees', 'before' => 'auth'], function()
{
	Route::get('showDegrees', [
		'as' => 'showDegrees_path',
		'uses' => 'DegreesController@index'
		]);

	Route::get('{degree}/editDegreeInformation', [
		'as' => 'editDegreeInformation_path',
		'uses' => 'DegreesController@edit'
		]);

	Route::delete('{degree}/deleteDegree', [
		'as' => 'deleteDegree_path',
		'uses' => 'DegreesController@destroy'
		]);

	Route::patch('{degree}/updateDegree', [
		'as' => 'updateDegree_path',
		'uses' => 'DegreesController@update'
		]);

	Route::post('saveDegree', [
		'as' => 'saveDegree_path',
		'uses' => 'DegreesController@store'
		]);
});