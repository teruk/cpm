<?php

// Routes for RoomsController
Route::group(['prefix' => 'rooms', 'before' => 'auth'], function()
{
	Route::get('showRooms', [
		'as' => 'showRooms_path',
		'uses' => 'RoomsController@index'
		]);

	Route::get('{room}/showRoom', [
		'as' => 'showRoom_path',
		'uses' => 'RoomsController@show'
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

	/** room search routes */
	Route::get('showSearchForm', [
		'as' => 'showRoomSearchForm_path',
		'uses' => 'RoomSearchController@showRoomSearch'
		]);

	Route::patch('showResults', [
		'as' => 'showRoomSearchResults_path',
		'uses' => 'RoomSearchController@search'
		]);
});