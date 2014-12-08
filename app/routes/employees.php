<?php
// Routes for EmployeesController
Route::group(['prefix' => 'employees', 'before' => 'auth'], function ()
{
	Route::get('', 'EmployeesController@index');
	Route::get('', array('as' => 'employees.index', 'uses' => 'EmployeesController@index'));
	Route::get('{employee}/show', array('as' => 'employees.show', 'uses' => 'EmployeesController@show'));
	Route::delete('{employee}/delete', array('as' => 'employees.destroy', 'uses' => 'EmployeesController@destroy'));
	Route::patch('{employee}/update', array('as' => 'employees.update', 'uses' => 'EmployeesController@update'));
	Route::post('save', array('as' => 'employees.store', 'uses' => 'EmployeesController@store'));
});