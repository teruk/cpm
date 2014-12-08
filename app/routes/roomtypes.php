<?php
// Routes for RoomTypesController
Route::group(['prefix' => 'roomtypes', 'before' => 'auth'], function()
{
	Route::get('/', 'RoomTypesController@index');
	Route::get('/', array('as' => 'roomtypes.index', 'uses' => 'RoomTypesController@index'));
	Route::get('{roomtype}/show', array('as' => 'roomtypes.show', 'uses' => 'RoomTypesController@show'));
	Route::delete('{roomtype}/delete', array('as' => 'roomtypes.destroy', 'uses' => 'RoomTypesController@destroy'));
	Route::patch('{roomtype}/update', array('as' => 'roomtypes.update', 'uses' => 'RoomTypesController@update'));
	Route::post('save', array('as' => 'roomtypes.store', 'uses' => 'RoomTypesController@store'));
});