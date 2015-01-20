<?php

// Routes for OverviewController
Route::group(['prefix' => 'overview'], function ()
{

/** courses overview */
Route::get('showCourses', [
	'as' => 'showOverviewCourses_path',
	'uses' => 'OverviewController@showCourses'
	]);

Route::get('showCourses/{course}', [
	'as' => 'showOverviewSelectedCourse_path',
	'uses' => 'OverviewController@showSelectedCourse'
	]);

/** modules overview */
Route::get('showModules', [
	'as' => 'showOverviewModules_path',
	'uses' => 'OverviewController@showModules'
	]);

Route::get('showModules/{module}', [
	'as' => 'showOverviewSelectedModule_path',
	'uses' => 'OverviewController@showSelectedModule'
	]);

/** degreecourse overview */
Route::get('showDegreecourses', [
	'as' => 'showOverviewDegreecourses_path',
	'uses' => 'OverviewController@showDegreecourses'
	]);

Route::get('showDegreecourses/{specialistregulation}', [
	'as' => 'showOverviewSelectedDegreecourse_path',
	'uses' => 'OverviewController@showSelectedDegreecourse'
	]);

/** employee overview */
Route::get('showEmployees', [
	'as' => 'showOverviewEmployees_path',
	'uses' => 'OverviewController@showEmployees'
	]);

Route::get('showEmployees/{employee}', [
	'as' => 'showOverviewSelectedEmployee_path',
	'uses' => 'OverviewController@showSelectedEmployee'
	]);

/** table overview for planning */
Route::get('showPlanningsOrderByCourseNumber/{turn}', [
	'as' => 'showPlanningsOrderByCourseNumber_path',
	'uses' => 'OverviewController@getTablePlannings'
	]);

Route::get('showPlanningsOrderByResearchgroup/{turn}', [
	'as' => 'showPlanningsOrderByResearchgroup_path',
	'uses' => 'OverviewController@getTableResearchgroups'
	]);

/** exam overview */
Route::get('showExams/{turn}', [
	'as' => 'showExams_path',
	'uses' => 'OverviewController@showExams'
	]);

/** student assistant overview */
Route::get('showStudentAssistants/{turn}', [
	'as' => 'showStudentAssistants_path',
	'uses' => 'OverviewController@showStudentAssistants'
	]);

/** medium term planning overview */
Route::get('showMediumTermPlannings', [
	'as' => 'showMediumTermPlannings_path',
	'uses' => 'MediumtermplanningsController@index'
	]);

/** degree course schedule overview */
Route::get('showDefaultSchedule/{turn}', [
	'as' => 'showDefaultSchedule_path',
	'uses' => 'ScheduleController@getDefaultSchedule'
	]);

Route::get('showSchedule/{turn}/{specialistregulation}/{semester}', [
	'as' => 'showSchedule_path',
	'uses' => 'ScheduleController@getSchedule'
	]);

Route::get('showSelectedSchedule', [
	'as' => 'showSelectedSchedule_path',
	'uses' => 'ScheduleController@generateSchedule'
	]);

Route::patch('fetchSchedule', [
	'as' => 'fetchSchedule_path',
	'uses' => 'ScheduleController@fetchSchedule'
	]);

/** room occupation overview */
Route::get('showDefaultRoomOccupation/{turn}', [
	'as' => 'showDefaultRoomOccupation_path',
	'uses' => 'RoomOccupationController@getDefaultRoom'
	]);

Route::get('showRoomOccupation/{turn}/{room}', [
	'as' => 'showRoomOccupation_path',
	'uses' => 'RoomOccupationController@getSpecificRoom'
	]);

Route::get('showSelectedRoomOccupation', [
	'as' => 'showSelectedRoomOccupation_path',
	'uses' => 'RoomOccupationController@generateRoom'
	]);

Route::patch('fetchRoomOccupation', [
	'as' => 'fetchRoomOccupation_path',
	'uses' => 'RoomOccupationController@fetchRoom'
	]);
});
