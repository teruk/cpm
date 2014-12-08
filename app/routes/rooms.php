<?php

// Routes for RoomsController
Route::group(['prefix' => 'rooms', 'before' => 'auth'], function()
{
	Route::get('/', 'RoomsController@index');
	Route::get('/', array('as' => 'rooms.index', 'uses' => 'RoomsController@index'));
	Route::get('{room}/show', array('as' => 'rooms.show', 'uses' => 'RoomsController@show'));
	Route::delete('{room}/delete', array('as' => 'rooms.destroy', 'uses' => 'RoomsController@destroy'));
	Route::patch('{room}/update', array('as' => 'rooms.update', 'uses' => 'RoomsController@update'));
	Route::post('save', array('as' => 'rooms.store', 'uses' => 'RoomsController@store'));
});