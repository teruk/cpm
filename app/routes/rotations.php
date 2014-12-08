<?php

// Routes for RotationsController
Route::group(['prefix' => 'rotations', 'before' => 'auth'], function()
{
	Route::get('/', 'RotationsController@index');
	Route::get('/', array('as' => 'rotations.index', 'uses' => 'RotationsController@index'));
	Route::get('{rotation}/show', array('as' => 'rotations.show', 'uses' => 'RotationsController@show'));
	Route::delete('{rotation}/delete', array('as' => 'rotations.destroy', 'uses' => 'RotationsController@destroy'));
	Route::patch('{rotation}/update', array('as' => 'rotations.update', 'uses' => 'RotationsController@update'));
	Route::post('save', array('as' => 'rotations.store', 'uses' => 'RotationsController@store'));
});