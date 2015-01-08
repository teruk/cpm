<?php
// Routes for DegreecoursesController

Route::group(['prefix' => 'degreecourses', 'before' => 'auth'], function()
{
	Route::get('showDegreecourses', [
		'as' => 'showDegreecourses_path',
		'uses' => 'DegreecoursesController@index'
		]);

	Route::get('{degreecourse}/showDegreecourse', [
		'as' => 'showDegreecourse_path',
		'uses' => 'DegreecoursesController@show'
		]);

	Route::delete('{degreecourse}/deleteDegreecourse', [
		'as' => 'deleteDegreecourse_path',
		'uses' => 'DegreecoursesController@destroy'
		]);

	Route::patch('{degreecourse}/updateDegreecourse', [
		'as' => 'updateDegreecourse_path',
		'uses' => 'DegreecoursesController@update'
		]);

	Route::post('saveDegreecourse', [
		'as' => 'saveDegreecourse_path',
		'uses' => 'DegreecoursesController@store'
		]);
});
