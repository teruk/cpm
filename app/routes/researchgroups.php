<?php

Route::group(['prefix' => 'researchgroups', 'before' => 'auth'], function()
{
	Route::get('showResearchgroups', [
		'as' => 'showResearchgroups_path',
		'uses' => 'ResearchgroupsController@index'
		]);

	Route::get('{researchgroup}/editResearchgroupInformation', [
		'as' => 'editResearchgroupInformation_path',
		'uses' => 'ResearchgroupsController@edit'
		]);

	Route::get('{researchgroup}/showResearchgroupEmployees', [
		'as' => 'showResearchgroupEmployees_path',
		'uses' => 'ResearchgroupsController@showEmployees'
		]);

	Route::get('{researchgroup}/showResearchgroupCourses', [
		'as' => 'showResearchgroupCourses_path',
		'uses' => 'ResearchgroupsController@showCourses'
		]);

	Route::delete('{researchgroup}/deleteResearchgroup', [
		'as' => 'deleteResearchgroup_path',
		'uses' => 'ResearchgroupsController@destroy'
		]);

	Route::patch('{researchgroup}/updateResearchgroup', [
		'as' => 'updateResearchgroup_path',
		'uses' => 'ResearchgroupsController@update'
		]);

	Route::post('saveResearchgroup', [
		'as' => 'saveResearchgroup_path',
		'uses' => 'ResearchgroupsController@store'
		]);
});
