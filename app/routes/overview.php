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

Route::get('showDegreecourses/{degreecourse}', [
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
Route::get('overview/schedule', [
	'as' => 'overview.default_schedule',
	'uses' => 'ScheduleController@getDefaultSchedule'
	]);

Route::get('overview/schedule/{turn}/{degreecourse}/{semester}', [
	'as' => 'overview.specific_schedule',
	'uses' => 'ScheduleController@getSpecificSchedule'
	]);

Route::get('overview/schedule_generate', [
	'as' => 'overview.generate_schedule',
	'uses' => 'ScheduleController@generateSchedule'
	]);

Route::patch('overview/schedule', [
	'as' => 'overview.grab_schedule',
	'uses' => 'ScheduleController@grabSchedule'
	]);

/** room occupation overview */
Route::get('overview/room', [
	'as' => 'overview.default_room',
	'uses' => 'RoomOccupationController@getDefaultRoom'
	]);

Route::get('overview/room/{turn}/{room}', [
	'as' => 'overview.specific_room',
	'uses' => 'RoomOccupationController@getSpecificRoom'
	]);

Route::get('overview/room_generate', [
	'as' => 'overview.generate_room',
	'uses' => 'RoomOccupationController@generateRoom'
	]);

Route::patch('overview/room', [
	'as' => 'overview.grab_room',
	'uses' => 'RoomOccupationController@grabRoom'
	]);
});