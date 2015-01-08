<?php

// Routes for SettingsController
Route::group(['prefix' => 'settings', 'before' => 'auth'], function()
{

	Route::get('showSettings', [
		'as' => 'showSettings_path',
		'uses' => 'SettingsController@index'
		]);

	Route::patch('updateCurrentTurn', [
		'as' => 'updateCurrentTurn_path',
		'uses' => 'SettingsController@updateCurrentTurn'
		]);
});