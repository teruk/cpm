<?php
// Routes for EmployeesController
Route::group(['prefix' => 'employees', 'before' => 'auth'], function ()
{
	Route::get('showEmployees', [
		'as' => 'showEmployees_path',
		'uses' => 'EmployeesController@index'
		]);

	Route::get('{employee}/showEmployee', [
		'as' => 'showEmployee_path',
		'uses' => 'EmployeesController@show'
		]);

	Route::delete('{employee}/deleteEmployee', [
		'as' => 'deleteEmployee_path',
		'uses' => 'EmployeesController@destroy'
		]);

	Route::patch('{employee}/updateEmployee', [
		'as' => 'updateEmployee_path',
		'uses' => 'EmployeesController@update'
		]);

	Route::post('saveEmployee', [
		'as' => 'saveEmployee_path',
		'uses' => 'EmployeesController@store'
		]);
});