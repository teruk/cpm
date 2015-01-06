<?php

// Routes for PlanningsController
Route::group(['prefix' => 'plannings', 'before' => 'auth'], function()
{
	/** show plannings index page */

	Route::get('{turn}/showTurnPlannings', [
		'as' => 'showTurnPlannings_path',
		'uses' => 'PlanningsController@index'
		]);

	Route::get('{turn}/showAllPlannings', [
		'as' => 'showAllPlannings_path',
		'uses' => 'PlanningsController@showall'
		]);

	/** Storing plannings */
	Route::post('{turn}/savePlanning', [
		'as' => 'savePlanning_path',
		'uses' => 'StorePlanningsController@store'
		]);

	Route::post('{turn}/savePlanningModule', [
		'as' => 'savePlanningModule_path',
		'uses' => 'StorePlanningsController@storeModule'
		]);

	Route::post('{turn}/savePlanningIndividual', [
		'as' => 'savePlanningIndividual_path',
		'uses' => 'StorePlanningsController@storeIndividual'
		]);

	/** Copy selected plannings */
	Route::post('{turn}/copySelectedPlannings', [
		'as' => 'copySelectedPlannings_path',
		'uses' => 'CopyPlanningsController@copySelected'
		]);

	Route::post('{turn}/copyPlanningsFromLastTurn', [
		'as' => 'copyPlanningsFromLastTurn_path',
		'uses' => 'CopyPlanningsController@copyTurn'
		]);

	/** Delete planning */
	Route::delete('{turn}/deletePlanning/{planning}', [
		'as' => 'deletePlanning_path',
		'uses' => 'PlanningsController@destroy'
		]);

	/** Modify planning status */
	Route::get('{turn}/showAllPlanningsStats', [
		'as' => 'showAllPlanningsStats_path',
		'uses' => 'PlanningsController@getStatusOverview'
		]);

	Route::post('{turn}/updateSelectedPlanningsStats', [
		'as' => 'updateSelectedPlanningsStats_path',
		'uses' => 'PlanningsController@updateStatus'
		]);

	/** Generate plannings from medium term planning */
	Route::patch('{turn}/generateFromMediumtermplanning', [
		'as' => 'generateFromMediumtermplanning_path',
		'uses' => 'GenerateMediumtermplanningsController@generatePlannings'
		]);

	/** Edit general planning information */
	Route::get('{turn}/show/{planning}/editPlanning', [
		'as' => 'editPlanningInformation_path',
		'uses' => 'EditPlanningController@showInformation'
		]);

	Route::patch('{turn}/show/{planning}/editPlanning', [
		'as' => 'updatePlanningInformation_path',
		'uses' => 'EditPlanningController@updateInformation'
		]);

	/** exam */
	Route::get('{turn}/show/{planning}/showExam', [
		'as' => 'editPlanningExam_path',
		'uses' => 'EditPlanningController@showExam'
		]);

	Route::patch('{turn}/show/{planning}/updateExam', [
		'as' => 'updatePlanningExam_path',
		'uses' => 'EditPlanningController@updateExam'
		]);

	/** show planning protocol */
	Route::get('{turn}/show/{planning}/showProtocol', [
		'as' => 'showPlanningProtocol_path',
		'uses' => 'EditPlanningController@showProtocol'
		]);

	/** show room preferences */
	Route::get('{turn}/showRoomPreference', [
		'as' => 'showRoomPreference_path',
		'uses' => 'RoomPreferencesController@showRoomPreference'
		]);

	/** show researchgroup week schedule */
	Route::get('{turn}/showWeeklySchedule', [
		'as' => 'showWeeklySchedule_path',
		'uses' => 'ResearchgroupWeeklyScheduleController@show'
		]);
});