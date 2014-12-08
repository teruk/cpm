<?php

// Routes for CoursesController
Route::group(['prefix' => 'courses', 'before' => 'auth'], function()
{
	Route::get('/', 'CoursesController@index');
	Route::get('/', array('as' => 'courses.index', 'uses' => 'CoursesController@index'));
	Route::get('{course}/show', array('as' => 'courses.show', 'uses' => 'CoursesController@show'));
	Route::delete('{course}/delete', array('as' => 'courses.destroy', 'uses' => 'CoursesController@destroy'));
	Route::patch('{course}/update', array('as' => 'courses.update', 'uses' => 'CoursesController@update'));
	Route::post('save', array('as' => 'courses.store', 'uses' => 'CoursesController@store'));
});