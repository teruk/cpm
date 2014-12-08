<?php

// Routes for MediumtermplanningsController
Route::get('mediumtermplannings', 'MediumtermplanningsController@index');

Route::get('mediumtermplannings', [
	'as' => 'mediumtermsplannings.index',
	'uses' => 'MediumtermplanningsController@index'
	]);