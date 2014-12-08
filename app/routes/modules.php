<?php
// Route for the ModulesController
Route::group(['prefix' => 'modules', 'before' => 'auth'], function()
{
	Route::get('/', 'ModulesController@index');
	Route::get('/', array('as' =>'modules.index', 'uses' => 'ModulesController@index'));
	Route::get('{module}/show', array('as' => 'modules.show', 'uses' => 'ModulesController@show'));
	Route::delete('{module}/delete', array('as' => 'modules.destroy', 'uses' => 'ModulesController@destroy'));
	Route::delete('{module}/detach', array('as' => 'modules.detach', 'uses' => 'ModulesController@detachDegreecourse'));
	Route::patch('{module}/update', array('as' => 'modules.update', 'uses' => 'ModulesController@update'));
	Route::patch('{module}/attach', array('as' => 'modules.attach', 'uses' => 'ModulesController@attachDegreecourse'));
	Route::patch('{module}/updateDegreecourse', array('as' => 'modules.updateDegreecourse', 'uses' => 'ModulesController@updateDegreecourse'));
	Route::post('save', array('as' => 'modules.store', 'uses' => 'ModulesController@store'));

	Route::delete('{module}/mediumtermplanning/{mediumtermplanning}/delete', array('as' => 'modules.destroyMediumtermplanning', 'uses' => 'ModulesController@destroyMediumtermplanning'));
	Route::post('{module}/mediumtermplanning/add', array('as' => 'modules.addMediumtermplanning', 'uses' => 'ModulesController@storeMediumtermplanning'));
	Route::patch('{module}/mediumtermplanning/copy', array('as' => 'modules.copyMediumtermplanning', 'uses' => 'ModulesController@copyMediumtermplanning'));

	Route::get('{module}/mediumtermplanning/{mediumtermplanning}/edit', array('as' => 'modules.editMediumtermplanning', 'uses' => 'ModulesController@editMediumtermplanning'));
	Route::delete('{module}/mediumtermplanning/{mediumtermplanning}/delete_employee', array('as' => 'modules.destroyEmployee', 'uses' => 'ModulesController@destroyEmployee'));
	Route::patch('{module}/mediumtermplanning/{mediumtermplanning}/update_employee', array('as' => 'modules.updateEmployee', 'uses' => 'ModulesController@updateEmployee'));
	Route::post('{module}/mediumtermplanning/{mediumtermplanning}/add_employee', array('as' => 'modules.addEmployee', 'uses' => 'ModulesController@addEmployee'));	
});
