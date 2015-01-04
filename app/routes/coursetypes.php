<?php

// Routes for CoursetypesController
Route::group(['prefix' => 'coursetypes', 'before' => 'auth'], function()
{
	Route::get('/', 'CoursetypesController@index');
	Route::get('/', array('as' => 'coursetypes.index', 'uses' => 'CoursetypesController@index'));
	Route::get('{coursetype}/show', array('as' => 'coursetypes.show', 'uses' => 'CoursetypesController@show'));
	Route::delete('{coursetype}/delete', array('as' => 'coursetypes.destroy', 'uses' => 'CoursetypesController@destroy'));
	Route::patch('{coursetype}/update', array('as' => 'coursetypes.update', 'uses' => 'CoursetypesController@update'));
	Route::post('save', array('as' => 'coursetypes.store', 'uses' => 'CoursetypesController@store'));
});