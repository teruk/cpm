<?php

Route::group(['prefix' => 'researchgroups', 'before' => 'auth'], function()
{
	Route::get('showResearchgroups', [
		'as' => 'showResearchgroups_path',
		'uses' => 'ResearchgroupsController@index'
		]);

	Route::get('{researchgroup}/showResearchgroup', [
		'as' => 'showResearchgroup_path',
		'uses' => 'ResearchgroupsController@show'
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