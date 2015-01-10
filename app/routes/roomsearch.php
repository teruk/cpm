<?php

// Routes for RoomsController
Route::group(['prefix' => 'roomsearch'], function()
{
	/** room search routes */
	Route::get('showRoomSearchForm', [
		'as' => 'showRoomSearchForm_path',
		'uses' => 'RoomSearchController@showRoomSearch'
		]);

	Route::patch('showResults', [
		'as' => 'showRoomSearchResults_path',
		'uses' => 'RoomSearchController@search'
		]);
});