<?php
// Routes for SectionsController
Route::group(['prefix' => 'sections', 'before' => 'auth'], function()
{
	Route::get('showSections', [
		'as' => 'showSections_path',
		'uses' => 'SectionsController@index'
		]);

	Route::get('{section}/editSectionInformation', [
		'as' => 'editSectionInformation_path',
		'uses' => 'SectionsController@edit'
		]);

	Route::delete('{section}/deleteSection', [
		'as' => 'deleteSection_path',
		'uses' => 'SectionsController@destroy'
		]);

	Route::patch('{section}/updateSection', [
		'as' => 'updateSection_path',
		'uses' => 'SectionsController@update'
		]);

	Route::post('saveSection', [
		'as' => 'saveSection_path',
		'uses' => 'SectionsController@store'
		]);
});