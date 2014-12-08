<?php
// Routes for SectionsController
Route::group(['prefix' => 'sections', 'before' => 'auth'], function()
{
	Route::get('/', 'SectionsController@index');
	Route::get('/', array('as' => 'sections.index', 'uses' => 'SectionsController@index'));
	Route::get('{section}/show', array('as' => 'sections.show', 'uses' => 'SectionsController@show'));
	Route::delete('{section}/delete', array('as' => 'sections.destroy', 'uses' => 'SectionsController@destroy'));
	Route::patch('{section}/update', array('as' => 'sections.update', 'uses' => 'SectionsController@update'));
	Route::post('save', array('as' => 'sections.store', 'uses' => 'SectionsController@store'));
});