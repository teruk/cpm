<?php
// Routes for DepartmentsController
Route::group(['prefix' => 'departments', 'before' => 'auth'], function()
{
	Route::get('showDepartments', [
		'as' => 'showDepartments_path',
		'uses' => 'DepartmentsController@index'
		]);

	Route::get('{department}/showDepartment', [
		'as' => 'showDepartment_path',
		'uses' => 'DepartmentsController@show'
		]);

	Route::delete('{department}/deleteDepartment', [
		'as' => 'deleteDepartment_path',
		'uses' => 'DepartmentsController@destroy'
		]);

	Route::patch('{department}/updateDepartment', [
		'as' => 'updateDepartment_path',
		'uses' => 'DepartmentsController@update'
		]);

	Route::post('saveDepartment', [
		'as' => 'saveDepartment_path',
		'uses' => 'DepartmentsController@store'
		]);
});