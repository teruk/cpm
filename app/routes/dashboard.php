<?php
/* dashboard routes */
Route::get('dashboard', [
	'as' => 'dashboard_path',
	'before' => 'auth',
	'uses' => 'DashboardController@getDashboard'
	]);