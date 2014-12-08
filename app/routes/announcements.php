<?php
// Routes for AnnouncementsController
Route::group(['prefix' => 'announcements', 'before' => 'auth'], function()
{
	Route::get('/', 'AnnouncementsController@index');
	Route::get('/', array('as' => 'announcements.index', 'uses' => 'AnnouncementsController@index'));
	Route::get('{announcement}/show', array('as' => 'announcements.show', 'uses' => 'AnnouncementsController@show'));
	Route::delete('{announcement}/delete', array('as' => 'announcements.destroy', 'uses' => 'AnnouncementsController@destroy'));
	Route::patch('{announcement}/update', array('as' => 'announcements.update', 'uses' => 'AnnouncementsController@update'));
	Route::post('save', array('as' => 'announcements.store', 'uses' => 'AnnouncementsController@store'));
});