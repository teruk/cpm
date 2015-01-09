<?php

// Routes for CoursesController
Route::group(['prefix' => 'courses', 'before' => 'auth'], function()
{
	Route::get('showCourses', [
		'as' => 'showCourses_path',
		'uses' => 'CoursesController@index'
		]);

	Route::get('{course}/editCourseInformation', [
		'as' => 'editCourseInformation_path',
		'uses' => 'CoursesController@edit'
		]);

	Route::get('{course}/showCourseHistory', [
		'as' => 'showCourseHistory_path',
		'uses' => 'CoursesController@showHistory'
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