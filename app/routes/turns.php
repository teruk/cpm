<?php
// Routes for TurnsController
Route::group(['prefix' => 'turns', 'before' => 'auth'], function()
{
	Route::get('showTurns', [
		'as' => 'showTurns_path',
		'uses' => 'TurnsController@index'
		]);

	Route::get('{turn}/editTurnInformation', [
		'as' => 'editTurnInformation_path',
		'uses' => 'TurnsController@edit'
		]);

	Route::delete('{turn}/deleteTurn', [
		'as' => 'deleteTurn_path',
		'uses' => 'TurnsController@destroy'
		]);

	Route::patch('{turn}/updateTurn', [
		'as' => 'updateTurn_path',
		'uses' => 'TurnsController@update'
		]);

	Route::post('saveTurn', [
		'as' => 'saveTurn_path',
		'uses' => 'TurnsController@store'
		]);
});