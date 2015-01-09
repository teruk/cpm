<?php
// Routes for AnnouncementsController
Route::group(['prefix' => 'announcements', 'before' => 'auth'], function()
{
	Route::get('showAnnouncements', [
		'as' => 'showAnnouncements_path',
		'uses' => 'AnnouncementsController@index'
		]);

	Route::post('saveAnnouncement', [
		'as' => 'saveAnnouncement_path',
		'uses' => 'AnnouncementsController@store'
		]);

	Route::get('{announcement}/editAnnouncementInformation', [
		'as' => 'editAnnouncementInformation_path',
		'uses' => 'AnnouncementsController@edit'
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