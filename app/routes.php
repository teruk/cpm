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
Route::model('specialistregulation', 'Specialistregulation');

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

// Home routes
Route::get('/', [
	'as' => 'index',
	'uses' => 'HomeController@getIndex'
	]);