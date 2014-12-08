<?php

// log in and log out routes
Route::get('login', [
	'as' => 'login',
	'uses' => 'HomeController@showLogin'
	]);

Route::get('logout', [
	'as' =>  'logout',
	'uses' => 'HomeController@doLogout'
	]);

Route::post('login', array('uses' => 'HomeController@doLogin'));