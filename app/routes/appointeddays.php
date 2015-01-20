<?php
// Routes for AppointeddaysController
Route::group(['prefix' => 'appointeddays', 'before' => 'auth'], function()
{

	Route::get('showAppointeddays', [
		'as' => 'showAppointeddays_path',
		'uses' => 'AppointeddaysController@index'
		]);

	Route::get('{appointedday}/editAppointeddayInformation', [
		'as' => 'editAppointeddayInformation_path',
		'uses' => 'AppointeddaysController@edit'
		]);

	Route::get('{appointedday}/showInformation', [
		'as' => 'showAppointeddayInformation_path',
		'uses' => 'AppointeddaysController@info'
		]);

	Route::delete('{appointedday}/deleteAppointedday', [
		'as' => 'deleteAppointedday_path',
		'uses' => 'AppointeddaysController@destroy'
		]);

	Route::patch('{appointedday}/updateAppointedday', [
		'as' => 'updateAppointedday_path',
		'uses' => 'AppointeddaysController@update'
		]);

	Route::post('saveAppointedday', [
		'as' => 'saveAppointedday_path',
		'uses' => 'AppointeddaysController@store'
		]);
});
