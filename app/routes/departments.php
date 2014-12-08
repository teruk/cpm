<?php
// Routes for DepartmentsController
Route::group(['prefix' => 'departments', 'before' => 'auth'], function()
{
	Route::get('/', 'DepartmentsController@index');
	Route::get('/', array('as' => 'departments.index', 'uses' => 'DepartmentsController@index'));
	Route::get('{department}/show', array('as' => 'departments.show', 'uses' => 'DepartmentsController@show'));
	Route::delete('{department}/delete', array('as' => 'departments.destroy', 'uses' => 'DepartmentsController@destroy'));
	Route::patch('{department}/update', array('as' => 'departments.update', 'uses' => 'DepartmentsController@update'));
	Route::post('save', array('as' => 'departments.store', 'uses' => 'DepartmentsController@store'));
});