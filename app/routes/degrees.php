<?php

// Routes for DegreesController
Route::group(['prefix' => 'degrees', 'before' => 'auth'], function()
{
	Route::get('/', 'DegreesController@index');
	Route::get('/', array('as' => 'degrees.index', 'uses' => 'DegreesController@index'));
	Route::get('{degree}/show', array('as' => 'degrees.show', 'uses' => 'DegreesController@show'));
	Route::delete('{degree}/delete', array('as' => 'degrees.destroy', 'uses' => 'DegreesController@destroy'));
	Route::patch('{degree}/update', array('as' => 'degrees.update', 'uses' => 'DegreesController@update'));
	Route::post('save', array('as' => 'degrees.store', 'uses' => 'DegreesController@store'));
});