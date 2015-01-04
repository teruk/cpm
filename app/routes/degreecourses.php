<?php
// Routes for DegreecoursesController

Route::group(['prefix' => 'degree_courses', 'before' => 'auth'], function()
{
	Route::get('/', 'DegreecoursesController@index');
	Route::get('/', array('as' => 'degree_courses.index', 'uses' => 'DegreecoursesController@index'));
	Route::get('{degreecourse}/show', array('as' => 'degree_courses.show', 'uses' => 'DegreecoursesController@show'));
	Route::delete('{degreecourse}/delete', array('as' => 'degree_courses.destroy', 'uses' => 'DegreecoursesController@destroy'));
	Route::patch('{degreecourse}/update', array('as' => 'degree_courses.update', 'uses' => 'DegreecoursesController@update'));
	Route::post('save', array('as' => 'degree_courses.store', 'uses' => 'DegreecoursesController@store'));
});
