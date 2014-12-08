<?php

// Routes for CourseTypesController
Route::group(['prefix' => 'coursetypes', 'before' => 'auth'], function()
{
	Route::get('/', 'CourseTypesController@index');
	Route::get('/', array('as' => 'coursetypes.index', 'uses' => 'CourseTypesController@index'));
	Route::get('{coursetype}/show', array('as' => 'coursetypes.show', 'uses' => 'CourseTypesController@show'));
	Route::delete('{coursetype}/delete', array('as' => 'coursetypes.destroy', 'uses' => 'CourseTypesController@destroy'));
	Route::patch('{coursetype}/update', array('as' => 'coursetypes.update', 'uses' => 'CourseTypesController@update'));
	Route::post('save', array('as' => 'coursetypes.store', 'uses' => 'CourseTypesController@store'));
});