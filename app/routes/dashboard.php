<?php
/* dashboard routes */
Route::get('home', [
	'as' => 'home',
	'before' => 'auth',
	'uses' => 'DashboardController@getDashboard'
	]);