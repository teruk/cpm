<?php

// Routes for RoomsController
Route::group(['prefix' => 'rooms', 'before' => 'auth'], function()
{
	Route::get('showRooms', [
		'as' => 'showRooms_path',
		'uses' => 'RoomsController@index'
		]);

	Route::get('{room}/editRoomInformation', [
		'as' => 'editRoomInformation_path',
		'uses' => 'RoomsController@edit'
		]);

	Route::delete('{room}/deleteRoom', [
		'as' => 'deleteRoom_path',
		'uses' => 'RoomsController@destroy'
		]);

	Route::patch('{room}/updateRoom', [
		'as' => 'updateRoom_path',
		'uses' => 'RoomsController@update'
		]);

	Route::post('saveRoom', [
		'as' => 'saveRoom_path',
		'uses' => 'RoomsController@store'
		]);
});
