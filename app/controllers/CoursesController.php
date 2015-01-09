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
			Flash::success('Lehrveranstaltung erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($course->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /courses/{id}
	 *
	 * @param  int  Course $course
	 * @return Response
	 */
	public function edit(Course $course)
	{	
		$listofcoursetypes = Coursetype::lists('name','id');
		$listofmodules = Module::orderBy('name','ASC')->lists('name','id');		
		
		$this->layout->content = View::make('courses.editInformation', compact('course','listofcoursetypes', 'listofmodules','history'));
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
			return Redirect::back();
		}

		Flash::error($course->errors());
		return Redirect::back()->withInput();
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

	/**
	 * show course history
	 * @param  Course $course [description]
	 * @return [type]         [description]
	 */
	public function showHistory(Course $course)
	{
		// get the information for the course history
		$history = Planning::courses($course)->get();
		$this->layout->content = View::make('courses.history', compact('course', 'history'));
	}
	
	// public function export()
	// {
	// 	$courses = Course::all();
	// 	$this->layout->content = View::make('courses.export', compact('courses'));
	// }

}