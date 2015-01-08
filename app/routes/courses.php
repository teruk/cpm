<?php

// Routes for CoursesController
Route::group(['prefix' => 'courses', 'before' => 'auth'], function()
{
	Route::get('showCourses', [
		'as' => 'showCourses_path',
		'uses' => 'CoursesController@index'
		]);

	Route::get('{course}/showCourse', [
		'as' => 'showCourse_path',
		'uses' => 'CoursesController@show'
		]);

	Route::delete('{course}/deleteCourse', [
		'as' => 'deleteCourse_path',
		'uses' => 'CoursesController@destroy'
		]);

	Route::patch('{course}/updateCourse', [
		'as' => 'updateCourse_path',
		'uses' => 'CoursesController@update'
		]);

	Route::post('saveCourse', [
		'as' => 'saveCourse_path',
		'uses' => 'CoursesController@store'
		]);
});