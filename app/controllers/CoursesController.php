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
		$courses = Course::with('coursetype')->get();
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
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
		{
			// check the origin of the save request
			if (Input::get('tabindex') == "")
			{
				Flash::success('Lehrveranstaltung erfolgreich erstellt!');
				return Redirect::back();
			}

			// back to module show
			$module = Module::find($course->module_id);
			Flash::success('Lehrveranstaltung erfolgreich erstellt!');
			return Redirect::route('modules.show',$module->id)->with('tabindex', Input::get('tabindex'));
		}

		if (Input::get('tabindex') == "")
		{
			Flash::error($course->errors());
			return Redirect::back()->withInput();
		}

		// back to module show
		$module = Module::find($course->module_id);
		Flash::error($course->errors());
		return Redirect::route('modules.show', $module->id)->withInput()->with('tabindex', Input::get('tabindex'));
			
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
		$listofcoursetypes = Coursetype::lists('name','id');
		$listofmodules = Module::orderBy('name','ASC')->lists('name','id');
		if (sizeof(Session::get('tabindex')) == "")
			$tabindex = 0;
		else 
			$tabindex = Session::get('tabindex');
		
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
		{
			Flash::success('Der Lehrveranstaltung wurde aktualisiert.');
			return Redirect::route('courses.show', $course->id);
		}

		Flash::error($course->errors());
		return Redirect::route('courses.show', array_get($course->getOriginal(), 'id'))->withInput();
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
		Flash::success('Lehrveranstaltung erfolgreich gelöscht.');
		return Redirect::back();
	}
	
	// public function export()
	// {
	// 	$courses = Course::all();
	// 	$this->layout->content = View::make('courses.export', compact('courses'));
	// }

}