<?php
// Routes for TurnsController
Route::group(['prefix' => 'turns', 'before' => 'auth'], function()
{
	Route::get('/', 'TurnsController@index');
	Route::get('/', array('as' => 'turns.index', 'uses' => 'TurnsController@index'));
	Route::get('{turn}/show', array('as' => 'turns.show', 'uses' => 'TurnsController@show'));
	Route::delete('{turn}/delete', array('as' => 'turns.destroy', 'uses' => 'TurnsController@destroy'));
	Route::patch('{turn}/update', array('as' => 'turns.update', 'uses' => 'TurnsController@update'));
	Route::post('store', array('as' => 'turns.store', 'uses' => 'TurnsController@store'));
});