<?php
// Routes for RoomTypesController
Route::group(['prefix' => 'roomtypes', 'before' => 'auth'], function()
{
	Route::get('showRoomtypes', [
		'as' => 'showRoomtypes_path',
		'uses' => 'RoomtypesController@index'
		]);

	Route::get('{roomtype}/editRoomtypeInformation', [
		'as' => 'editRoomtypeInformation_path',
		'uses' => 'RoomtypesController@edit'
		]);

	Route::delete('{roomtype}/deleteRoomtype', [
		'as' => 'deleteRoomtype_path',
		'uses' => 'RoomtypesController@destroy'
		]);

	Route::patch('{roomtype}/updateRoomtype', [
		'as' => 'updateRoomtype_path',
		'uses' => 'RoomtypesController@update'
		]);

	Route::post('saveRoomtype', [
		'as' => 'saveRoomtype_path',
		'uses' => 'RoomtypesController@store'
		]);
});
