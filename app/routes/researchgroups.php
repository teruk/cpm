<?php

Route::group(['prefix' => 'researchgroups', 'before' => 'auth'], function()
{
// Routes for ResearchGroupsController
	Route::get('/', 'ResearchGroupsController@index');
	Route::get('/', array('as' => 'researchgroups.index', 'uses' => 'ResearchGroupsController@index'));
	Route::get('{researchgroup}/show', array('as' => 'researchgroups.show', 'uses' => 'ResearchgroupsController@show'));
	Route::delete('{researchgroup}/delete', array('as' => 'researchgroups.destroy', 'uses' => 'ResearchGroupsController@destroy'));
	Route::patch('{researchgroup}/update', array('as' => 'researchgroups.update', 'uses' => 'ResearchGroupsController@update'));
	Route::post('save', array('as' => 'researchgroups.store', 'uses' => 'ResearchGroupsController@store'));
});