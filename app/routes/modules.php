<?php
// Route for the ModulesController
Route::group(['prefix' => 'modules', 'before' => 'auth'], function()
{
	/** general module routes */
	Route::get('showModules', [
		'as' => 'showModules_path',
		'uses' => 'ModulesController@index'
		]);

	Route::get('{module}/editModuleInformation', [
		'as' => 'editModuleInformation_path',
		'uses' => 'ModulesController@edit'
		]);

	Route::get('{module}/showModuleCourses', [
		'as' => 'showModuleCourses_path',
		'uses' => 'ModulesController@showCourses'
		]);

	Route::get('{module}/showModuleDegreecourses', [
		'as' => 'showModuleDegreecourses_path',
		'uses' => 'ModulesController@showDegreecourses'
		]);

	Route::get('{module}/showModuleMediumtermplannings', [
		'as' => 'showModuleMediumtermplannings_path',
		'uses' => 'ModulesController@showMediumtermplannings'
		]);

	Route::delete('{module}/deleteModule', [
		'as' => 'deleteModule_path',
		'uses' => 'ModulesController@destroy'
		]);

	Route::patch('{module}/updateModule', [
		'as' => 'updateModule_path',
		'uses' => 'ModulesController@update'
		]);

	Route::post('saveModule', [
		'as' => 'saveModule_path',
		'uses' => 'ModulesController@store'
		]);

	/** module degree course relationship routes */
	Route::delete('{module}/detachDegreecourse', [
		'as' => 'detachDegreecourseModule_path',
		'uses' => 'ModulesController@detachDegreecourse'
		]);

	Route::patch('{module}/attachDegreecourse', [
		'as' => 'attachDegreecourseModule_path',
		'uses' => 'ModulesController@attachDegreecourse'
		]);

	Route::patch('{module}/updateDegreecourse', [
		'as' => 'updateDegreecourseModule_path',
		'uses' => 'ModulesController@updateDegreecourse'
		]);

	/** general module mediumterm planning routes */
	Route::delete('{module}/deleteMediumtermplanning/{mediumtermplanning}', [
		'as' => 'deleteMediumtermplanning_path',
		'uses' => 'MediumtermplanningsController@destroy'
		]);

	Route::post('{module}/saveMediumtermplanning', [
		'as' => 'saveMediumtermplanning_path',
		'uses' => 'MediumtermplanningsController@store'
		]);

	Route::patch('{module}/copyMediumtermplanning', [
		'as' => 'copyMediumtermplanning_path',
		'uses' => 'MediumtermplanningsController@copy'
		]);

	/** edit module mediumterm planning routes */
	Route::group(['prefix' => '{module}/mediumtermplanning/{mediumtermplanning}', 'before' => 'auth'], function()
	{
		Route::get('editMediumtermplanning', [
			'as' => 'editMediumtermplanning_path',
			'uses' => 'MediumtermplanningsController@edit'
			]);

		Route::delete('detachEmployee', [
			'as' => 'detachEmployeeMediumtermplanning_path',
			'uses' => 'MediumtermplanningsController@detachEmployee'
			]);

		Route::post('attachEmployee', [
			'as' => 'attachEmployeeMediumtermplanning_path',
			'uses' => 'MediumtermplanningsController@attachEmployee'
			]);

		Route::patch('updateEmployee', [
			'as' => 'updateEmployeeMediumtermplanning_path',
			'uses' => 'MediumtermplanningsController@updateEmployee'
			]);
	});
});
