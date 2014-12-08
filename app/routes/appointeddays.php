<?php
// Routes for AppointeddaysController
Route::group(['prefix' => 'appointeddays', 'before' => 'auth'], function()
{
	Route::get('/', 'AppointeddaysController@index');
	Route::get('/', array('as' => 'appointeddays.index', 'uses' => 'AppointeddaysController@index'));
	Route::get('{appointedday}/show', array('as' => 'appointeddays.show', 'uses' => 'AppointeddaysController@show'));
	Route::get('{appointedday}/info', array('as' => 'appointeddays.info', 'uses' => 'AppointeddaysController@info'));
	Route::delete('{appointedday}/delete', array('as' => 'appointeddays.destroy', 'uses' => 'AppointeddaysController@destroy'));
	Route::patch('{appointedday}/update', array('as' => 'appointeddays.update', 'uses' => 'AppointeddaysController@update'));
	Route::post('save', array('as' => 'appointeddays.store', 'uses' => 'AppointeddaysController@store'));
});