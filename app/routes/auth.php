<?php

// log in and log out routes
Route::get('login', [
	'as' => 'login_path',
	'uses' => 'HomeController@showLogin'
	]);

Route::get('logout', [
	'as' =>  'logout_path',
	'uses' => 'HomeController@doLogout'
	]);

Route::post('login', array('uses' => 'HomeController@doLogin'));