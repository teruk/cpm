<?php

// Routes for PlanningsController
Route::group(['prefix' => 'plannings', 'before' => 'auth'], function()
{
	Route::get('/', 'PlanningsController@index');
	Route::get('/', array('as' => 'plannings.index', 'uses' => 'PlanningsController@index'));
	Route::get('{turn}', array('as' => 'plannings.indexTurn', 'uses' => 'PlanningsController@indexTurn'));
	Route::get('{turn}/showall', array('as' => 'plannings.showall', 'uses' => 'PlanningsController@showall'));
	Route::get('{turn}/update_status', array('as' => 'plannings.statusOverview', 'uses' => 'PlanningsController@getStatusOverview'));
	Route::get('{turn}/show/{planning}/edit', array('as' => 'plannings.edit', 'uses' => 'PlanningsController@edit'));
	Route::delete('{turn}/delete/{planning}', array('as' => 'plannings.destroy', 'uses' => 'PlanningsController@destroy'));
	Route::patch('{turn}/show/{planning}/update', array('as' => 'plannings.update', 'uses' => 'PlanningsController@update'));
	Route::patch('{turn}/generateFromMediumtermplanning', array('as' => 'plannings.generateFromMediumtermplanning', 'uses' => 'PlanningsController@generatePlanningsFromMediumtermplanning'));
	Route::post('{turn}/copyselected', array('as' => 'plannings.copyselected', 'uses' => 'PlanningsController@copySelectedPlanning'));
	Route::post('{turn}/update_status', array('as' => 'plannings.updateStatus', 'uses' => 'PlanningsController@updateStatus'));
	Route::post('{turn}/save', array('as' => 'plannings.store', 'uses' => 'PlanningsController@store'));
	Route::post('{turn}/save_module', array('as' => 'plannings.storeModule', 'uses' => 'PlanningsController@storeModule'));
	Route::post('{turn}/save_individual', array('as' => 'plannings.storeIndividual', 'uses' => 'PlanningsController@storeIndividual'));
	Route::post('{turn}/save_project', array('as' => 'plannings.storeProject', 'uses' => 'PlanningsController@storeProject'));
	Route::post('{turn}/copylastturn', array('as' => 'plannings.copylastturn', 'uses' => 'PlanningsController@copyLastTurn'));

	Route::delete('{turn}/show/{planning}/delete_employee', array('as' => 'plannings.deleteEmployee', 'uses' => 'LecturerAssignmentController@detachLecturer'));
	Route::patch('{turn}/show/{planning}/update_employee', array('as' => 'plannings.updateEmployee', 'uses' => 'LecturerAssignmentController@updateLecturer'));
	Route::patch('{turn}/show/{planning}/copy_employee', array('as' => 'plannings.copyEmployee', 'uses' => 'LecturerAssignmentController@copyLecturer'));
	Route::post('{turn}/show/{planning}/add_employee', array('as' => 'plannings.addEmployee', 'uses' => 'LecturerAssignmentController@assignLecturer'));

	Route::delete('{turn}/show/{planning}/delete_room', array('as' => 'plannings.deleteRoom', 'uses' => 'RoomAssignmentController@destroyRoomAssignment'));
	Route::patch('{turn}/show/{planning}/update_room', array('as' => 'plannings.updateRoom', 'uses' => 'RoomAssignmentController@updateRoomAssignment'));
	Route::patch('{turn}/show/{planning}/copy_room', array('as' => 'plannings.copyRoom', 'uses' => 'RoomAssignmentController@copyRoomAssignment'));
	Route::post('{turn}/show/{planning}/add_room', array('as' => 'plannings.addRoom', 'uses' => 'RoomAssignmentController@assignRoom'));

	Route::patch('{turn}/show/{planning}/update_examType', array('as' => 'plannings.updateExamType', 'uses' => 'PlanningsController@updateExamType'));

	Route::get('schedule/{turn}', array('as' => 'plannings.showSchedule', 'uses' => 'PlanningsController@showSchedule'));

	Route::get('room_preference/{turn}', array('as' => 'plannings.showRoomPreference', 'uses' => 'PlanningsController@showRoomPreference'));
});