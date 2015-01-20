<?php

// Routes for RoomAssignmentController
Route::group(['prefix' => 'plannings', 'before' => 'auth'], function()
{
	/** room assignemnt */
	Route::get('{turn}/show/{planning}/showPlanningRoom', [
		'as' => 'editPlanningRoom_path',
		'uses' => 'RoomAssignmentController@showRooms'
		]);

	Route::delete('{turn}/show/{planning}/detachPlanningRoom', [
		'as' => 'detachPlanningRoom_path',
		'uses' => 'RoomAssignmentController@destroyRoomAssignment'
		]);

	Route::patch('{turn}/show/{planning}/updatePlanningRoom', [
		'as' => 'updatePlanningRoom_path',
		'uses' => 'RoomAssignmentController@updateRoomAssignment'
		]);

	Route::patch('{turn}/show/{planning}/copyPlanningRoom', [
		'as' => 'copyPlanningRoom_path',
		'uses' => 'RoomAssignmentController@copyRoomAssignment'
		]);

	Route::post('{turn}/show/{planning}/assignPlanningRoom', [
		'as' => 'assignPlanningRoom_path',
		'uses' => 'RoomAssignmentController@assignRoom'
		]);
});
