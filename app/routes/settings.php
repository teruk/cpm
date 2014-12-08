<?php

// Routes for SettingsController
Route::group(['prefix' => 'settings', 'before' => 'auth'], function()
{
	Route::get('/', 'SettingsController@index');
	Route::get('/', array('as' => 'settings.index', 'uses' => 'SettingsController@index'));
	Route::patch('save', array('as' => 'settings.updateCurrentTurn', 'uses' => 'SettingsController@updateCurrentTurn'));
});