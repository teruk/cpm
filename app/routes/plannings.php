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
	
	Route::post('{turn}/update_status', array('as' => 'plannings.updateStatus', 'uses' => 'PlanningsController@updateStatus'));

	Route::patch('{turn}/generateFromMediumtermplanning', array('as' => 'plannings.generateFromMediumtermplanning', 'uses' => 'GenerateMediumtermplanningsController@generatePlannings'));

	Route::post('{turn}/save', array('as' => 'plannings.store', 'uses' => 'StorePlanningsController@store'));
	Route::post('{turn}/save_module', array('as' => 'plannings.storeModule', 'uses' => 'StorePlanningsController@storeModule'));
	Route::post('{turn}/save_individual', array('as' => 'plannings.storeIndividual', 'uses' => 'StorePlanningsController@storeIndividual'));
	Route::post('{turn}/copy', array('as' => 'plannings.copy', 'uses' => 'CopyPlanningsController@copy'));

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

	Route::get('room_preference/{turn}', array('as' => 'plannings.showRoomPreference', 'uses' => 'RoomPreferencesController@showRoomPreference'));
});