<?php
// Routes for DegreecoursesController

Route::group(['prefix' => 'degreecourses', 'before' => 'auth'], function()
{
	Route::get('showDegreecourses', [
		'as' => 'showDegreecourses_path',
		'uses' => 'DegreecoursesController@index'
		]);

	Route::get('{degreecourse}/editDegreecourseInformation', [
		'as' => 'editDegreecourseInformation_path',
		'uses' => 'DegreecoursesController@edit'
		]);

	Route::get('{degreecourse}/showDegreecourseModules', [
		'as' => 'showDegreecourseModules_path',
		'uses' => 'DegreecoursesController@showModules'
		]);

	Route::delete('{degreecourse}/deleteDegreecourse', [
		'as' => 'deleteDegreecourse_path',
		'uses' => 'DegreecoursesController@destroy'
		]);

	Route::patch('{degreecourse}/updateDegreecourse', [
		'as' => 'updateDegreecourse_path',
		'uses' => 'DegreecoursesController@update'
		]);

	Route::post('saveDegreecourse', [
		'as' => 'saveDegreecourse_path',
		'uses' => 'DegreecoursesController@store'
		]);

	/** manage specialist regulations */
	Route::get('{degreecourse}/editDegreecourseSpecialistregulations', [
		'as' => 'editDegreecourseSpecialistregulations_path',
		'uses' => 'DegreecoursesController@showSpecialistregulations'
		]);

	Route::get('{degreecourse}/editSpecialistregualtion/{specialistregulation}', [
		'as' => 'editSpecialistregulation_path',
		'uses' => 'SpecialistregulationsController@edit'
		]);

	Route::delete('{degreecourse}/deleteSpecialistregualtion/{specialistregulation}', [
		'as' => 'deleteSpecialistregualtion_path',
		'uses' => 'SpecialistregulationsController@destroy'
		]);

	Route::patch('{degreecourse}/updateSpecialistregulation/{specialistregulation}', [
		'as' => 'updateSpecialistregulation_path',
		'uses' => 'SpecialistregulationsController@update'
		]);

	Route::post('{degreecourse}/saveSpecialistregulation', [
		'as' => 'saveSpecialistregulation_path',
		'uses' => 'SpecialistregulationsController@store'
		]);
});
