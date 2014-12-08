<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class CoursesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /courses
	 *
	 * @return Response
	 */
	public function index()
	{
		$courses = Course::all();
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		$listofmodules = Module::orderBy('name','ASC')->lists('name','id'); // list is different from Module::lists
		$this->layout->content = View::make('courses.index', compact('courses','listofcoursetypes', 'listofmodules'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /courses
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$course = new Course($input);
		$course->semester_periods_per_week = Input::get('semester_periods_per_week');
		$course->department_id = 1;
		if ( $course->save() )
			// check the origin of the save request
			if (Input::get('tabindex') == "")
			{
				return Redirect::route('courses.index')->with('message', 'Lehrveranstaltung erfolgreich erstellt!');
			}
			else 
			{
				// back to module show
				$module = Module::find($course->module_id);
				return Redirect::route('modules.show',$module->id)->with('message', 'Lehrveranstaltung erfolgreich erstellt!')
				->with('tabindex', Input::get('tabindex'));
			}
		else
			if (Input::get('tabindex') == "")
			{
				return Redirect::route('courses.index')->withInput()->withErrors( $course->errors() );
			}
			else
			{
				// back to module show
				$module = Module::find($course->module_id);
				return Redirect::route('modules.show', $module->id)->withInput()->withErrors( $course->errors() )
				->with('tabindex', Input::get('tabindex'));
			}
	}

	/**
	 * Display the specified resource.
	 * GET /courses/{id}
	 *
	 * @param  int  Course $course
	 * @return Response
	 */
	public function show(Course $course)
	{	
		$listofcoursetypes = CourseType::lists('name','id');
		$listofmodules = Module::orderBy('name','ASC')->lists('name','id');
		if (sizeof(Session::get('tabindex')) == "")
		{
			$tabindex = 0;
		}
		else {
			$tabindex = Session::get('tabindex');
		}
		
		// get the information for the course history
		$history = Planning::courses($course)->get();
		$this->layout->content = View::make('courses.show', compact('course','listofcoursetypes', 'listofmodules','tabindex', 'history'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /courses/{id}
	 *
	 * @param  int  Course $course
	 * @return Response
	 */
	public function update(Course $course)
	{
		$input = Input::all();
		$course->fill($input);
		$course->semester_periods_per_week = Input::get('semester_periods_per_week');
		$course->department_id = 1;
 
		if ( $course->updateUniques() )
			return Redirect::route('courses.show', $course->id)->with('message', 'Der Lehrveranstaltung wurde aktualisiert.');
		else
			return Redirect::route('courses.show', array_get($course->getOriginal(), 'id'))->withInput()->withErrors( $course->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /courses/{id}
	 *
	 * @param  int  Course $course
	 * @return Response
	 */
	public function destroy(Course $course)
	{
		$course->delete();
		return Redirect::route('courses.index')->with('message', 'Lehrveranstaltung erfolgreich gelöscht.');
	}
	
	// public function export()
	// {
	// 	$courses = Course::all();
	// 	$this->layout->content = View::make('courses.export', compact('courses'));
	// }

}