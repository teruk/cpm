<?php

Route::get('overview/shk', array('as' => 'overview.shk', 'uses' => 'OverviewController@shk'));
Route::get('overview/shk/{turn}', array('as' => 'overview.showShk', 'uses' => 'OverviewController@showShk'));

Route::get('overview/exams', array('as' => 'overview.exams', 'uses' => 'OverviewController@exams'));
Route::get('overview/exams/{turn}', array('as' => 'overview.showExams', 'uses' => 'OverviewController@showExams'));

Route::get('overview/courses', array('as' => 'overview.courses', 'uses' => 'OverviewController@getCourses'));
Route::get('overview/courses/{course}', array('as' => 'overview.course', 'uses' => 'OverviewController@getCourse'));

Route::get('overview/degreecourses', array('as' => 'overview.degreecourses', 'uses' => 'OverviewController@getDegreeCourses'));
Route::get('overview/degreecourses/{degreecourse}', array('as' => 'overview.degreecourse', 'uses' => 'OverviewController@getDegreeCourse'));

Route::get('overview/employees', array('as' => 'overview.employees', 'uses' => 'OverviewController@getEmployees'));
Route::get('overview/employees/{employee}', array('as' => 'overview.employee', 'uses' => 'OverviewController@getEmployee'));

Route::get('overview/modules', array('as' => 'overview.modules', 'uses' => 'OverviewController@getModules'));
Route::get('overview/modules/{module}', array('as' => 'overview.module', 'uses' => 'OverviewController@getModule'));

Route::get('overview/room_search', array('as' => 'overview.showRoomSearch', 'uses' => 'OverviewController@showRoomSearch'));
Route::patch('overview/room_search_results', array('as' => 'overview.roomSearch', 'uses' => 'OverviewController@roomSearch'));

Route::get('overview/table_researchgroups', array('as' => 'overview.tableRG', 'uses' => 'OverviewController@tableReseachgroups'));
Route::get('overview/table_researchgroups/{turn}', array('as' => 'overview.tableResearchgroups', 'uses' => 'OverviewController@getTableResearchgroups'));

Route::get('overview/table_plannings', array('as' => 'overview.tablePl', 'uses' => 'OverviewController@tablePlannings'));
Route::get('overview/table_plannings/{turn}', array('as' => 'overview.tablePlannings', 'uses' => 'OverviewController@getTablePlannings'));