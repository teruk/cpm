<?php
// Routes for DegreeCoursesController

Route::group(['prefix' => 'degree_courses', 'before' => 'auth'], function()
{
	Route::get('/', 'DegreeCoursesController@index');
	Route::get('/', array('as' => 'degree_courses.index', 'uses' => 'DegreeCoursesController@index'));
	Route::get('{degreecourse}/show', array('as' => 'degree_courses.show', 'uses' => 'DegreeCoursesController@show'));
	Route::delete('{degreecourse}/delete', array('as' => 'degree_courses.destroy', 'uses' => 'DegreeCoursesController@destroy'));
	Route::patch('{degreecourse}/update', array('as' => 'degree_courses.update', 'uses' => 'DegreeCoursesController@update'));
	Route::post('save', array('as' => 'degree_courses.store', 'uses' => 'DegreeCoursesController@store'));
});
