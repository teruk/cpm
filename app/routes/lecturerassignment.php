<?php

// Routes for RoomAssignmentController
Route::group(['prefix' => 'plannings', 'before' => 'auth'], function()
{
	/** lecturer assignment */
	Route::get('{turn}/show/{planning}/showPlanningLecturer', [
		'as' => 'editPlanningLecturer_path',
		'uses' => 'LecturerAssignmentController@showLecturer'
		]);

	Route::delete('{turn}/show/{planning}/detachPlanningLecturer', [
		'as' => 'detachPlanningLecturer_path',
		'uses' => 'LecturerAssignmentController@detachLecturer'
		]);

	Route::patch('{turn}/show/{planning}/updatePlanningLecturer', [
		'as' => 'updatePlanningLecturer_path',
		'uses' => 'LecturerAssignmentController@updateLecturer'
		]);

	Route::patch('{turn}/show/{planning}/copyPlanningLecturer', [
		'as' => 'copyPlanningLecturer_path',
		'uses' => 'LecturerAssignmentController@copyLecturer'
		]);

	Route::post('{turn}/show/{planning}/assignPlanningLecturer', [
		'as' => 'assignPlanningLecturer_path',
		'uses' => 'LecturerAssignmentController@assignLecturer'
		]);
});