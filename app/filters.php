<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login_path');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('dashboard_path');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|
| Entrust Route protection
|
*/
/** user filter */
Entrust::routeNeedsRoleOrPermission('users/*',array('Admin'),array('add_user', 'edit_user', 'delete_user', 'attach_user_role', 'detach_user_role', 'detach_user_researchgroup', 'attach_user_researchgroup', 'activate_user', 'deactivate_user'), Redirect::to('/'),false);

/** role filter */
Entrust::routeNeedsRoleOrPermission('roles/*',array('Admin'),array('add_role', 'edit_role', 'delete_role'), Redirect::to('/'),false);

Entrust::routeNeedsRoleOrPermission('permissions/*',array('Admin'),array('edit_permissions', 'add_permission', 'delete_permission'), Redirect::to('/'),false);

Entrust::routeNeedsRoleOrPermission('plannings/*/showRoomPreference',array('Admin'),array('view_room_preferences'), Redirect::to('/'),false);

Entrust::routeNeedsRoleOrPermission('plannings/*/showAllPlanningsStats',array('Admin'),array('change_planning_status'), Redirect::to('/'),false);

/** announcement filter */
Entrust::routeNeedsRoleOrPermission('announcements/*',array('Admin'),array('add_announcement', 'edit_announcement', 'delete_announcement'), Redirect::to('/'),false);

/** appointedday filter */
Entrust::routeNeedsRoleOrPermission('appointeddays/*',array('Admin'),array('add_appointedday', 'edit_appointedday', 'delete_appointedday'),Redirect::to('/'),false);

/** coursetype filter */
Entrust::routeNeedsRoleOrPermission('coursetypes/*',array('Admin'),array('add_coursetype', 'edit_coursetype', 'delete_coursetype'), Redirect::to('/'),false);

/** course filter */
Entrust::routeNeedsRoleOrPermission('courses/*',array('Admin'),array('add_course', 'edit_course', 'delete_course'), Redirect::to('/'),false);

/** degreecourse filter */
Entrust::routeNeedsRoleOrPermission('degreecourses/*',array('Admin'),array('add_degreecourse', 'edit_degreecourse', 'delete_degreecourse'), Redirect::to('/'),false);

/** degree filter */
Entrust::routeNeedsRoleOrPermission('degrees/*',array('Admin'),array('add_degree', 'edit_degree', 'delete_degree'), Redirect::to('/'),false);

/** department filter */
Entrust::routeNeedsRoleOrPermission('departments/*',array('Admin'),array('add_department', 'edit_department', 'delete_department'), Redirect::to('/'),false);

/** employee filter */
Entrust::routeNeedsRoleOrPermission('employees/*',array('Admin'),array('add_employee', 'edit_employee', 'delete_employee'), Redirect::to('/'),false);

/** module filter */
Entrust::routeNeedsRoleOrPermission('modules/*',array('Admin'),array('add_module', 'edit_module', 'delete_module', 'edit_mediumtermplanning', 'add_mediumtermplanning', 'delete_mediumtermplanning'), Redirect::to('/'),false);

/** researchgroup filter */
Entrust::routeNeedsRoleOrPermission('researchgroups/*',array('Admin'),array('add_researchgroup', 'edit_researchgroup', 'delete_researchgroup'), Redirect::to('/'),false);

/** room filter */
Entrust::routeNeedsRoleOrPermission('rooms/*',array('Admin'),array('add_room', 'edit_room', 'delete_room'), Redirect::to('/'),false);

/** roomtype filter */
Entrust::routeNeedsRoleOrPermission('roomtypes/*',array('Admin'),array('add_roomtype', 'edit_roomtype', 'delete_roomtype'), Redirect::to('/'),false);

/** rotation filter */
Entrust::routeNeedsRoleOrPermission('rotations/*',array('Admin'),array('add_rotation', 'edit_rotation', 'delete_rotation'), Redirect::to('/'),false);

/** section filter */
Entrust::routeNeedsRoleOrPermission('sections/*',array('Admin'),array('add_section', 'edit_section', 'delete_section'), Redirect::to('/'),false);

/** settings filter */
Entrust::routeNeedsRoleOrPermission('settings/*',array('Admin'),array('change_setting_current_turn'), Redirect::to('/'),false);
Entrust::routeNeedsRoleOrPermission('settings/showSettingCurrentTurn',array('Admin'),array('change_setting_current_turn'), Redirect::to('/'),false);

/** turn filter */
Entrust::routeNeedsRoleOrPermission('turns/*',array('Admin'),array('add_turn', 'edit_turn', 'delete_turn'), Redirect::to('/'),false);