<?php
// Routes for AnnouncementsController
Route::group(['prefix' => 'announcements', 'before' => 'auth'], function()
{
	Route::get('showAnnouncements', [
		'as' => 'showAnnouncements_path',
		'uses' => 'AnnouncementsController@index'
		]);

	Route::post('save', [
		'as' => 'saveAnnouncement_path',
		'uses' => 'AnnouncementsController@store'
		]);

	Route::get('{announcement}/showAnnouncement', [
		'as' => 'showAnnouncement_path',
		'uses' => 'AnnouncementsController@show'
		]);

	Route::delete('{announcement}/deleteAnnouncement', [
		'as' => 'deleteAnnouncement_path',
		'uses' => 'AnnouncementsController@destroy'
		]);

	Route::patch('{announcement}/updateAnnouncement', [
		'as' => 'updateAnnouncement_path',
		'uses' => 'AnnouncementsController@update'
		]);
});