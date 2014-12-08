<?php
use Illuminate\Support\Facades\Redirect;

/**
 * Provide controller methods with object instead of ID
 */
Route::model('module','Module');
Route::model('degreecourse','DegreeCourse');
Route::model('researchgroup','Researchgroup');
Route::model('employee','Employee');
Route::model('mediumtermplanning','Mediumtermplanning');
Route::model('department','Department');
Route::model('turn', 'Turn');
Route::model('section', 'Section');
Route::model('rotation', 'Rotation');
Route::model('degree', 'Degree');
Route::model('roomtype','RoomType');
Route::model('room','Room');
Route::model('coursetype', 'CourseType');
Route::model('course','Course');
Route::model('planning','Planning');
Route::model('user','User');
Route::model('role','Role');
Route::model('permission','Permission');
Route::model('announcement','Announcement');
Route::model('appointedday','Appointedday');

/**
 * Protecting from csrf
 */

Route::when('*', 'csrf', ['post','put','patch']);

/**
 * Pulling in partial route files from the routes directory
 */

foreach (File::allFiles(__DIR__.'/routes') as $partial)
{
	require_once $partial->getPathname();
}

/* 
	public routes 
	TODO: put them in partials
*/

Route::get('schedule', array('as' => 'schedule', 'uses' => 'RoomsController@schedule'));
Route::get('rooms/overview', array('as' => 'rooms.overview', 'uses' => 'RoomsController@overview'));
Route::get('rooms/{turn}/schedule/{room}', array('as' => 'rooms.showRoomSchedule', 'uses' => 'RoomsController@showRoomSchedule'));
Route::get('schedule/turn/{turn}/degreecourse/{degreecourse}/semester/{semester}', array('as' => 'schedule.semester', 'uses' => 'RoomsController@getSchedule'));
Route::patch('rooms/overview', array('as' => 'rooms.overview', 'uses' => 'RoomsController@getOverview'));
Route::patch('schedule/degreecourse_schedule', array('as' => 'schedule.degreecourseSchedule', 'uses' => 'RoomsController@getDegreeCourseSchedule'));

// Home routes
Route::get('/', [
	'as' => 'index',
	'uses' => 'HomeController@getIndex'
	]);