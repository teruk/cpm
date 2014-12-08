<?php

use Illuminate\Support\Facades\Redirect;
class CourseTypesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /coursetypes
	 *
	 * @return Response
	 */
	public function index()
	{
		$coursetypes = CourseType::all();
		$this->layout->content = View::make('coursetypes.index', compact('coursetypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /coursetypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
// 		$this->layout->content = View::make('degree_courses.index');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /coursetypes
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$coursetype = new CourseType($input);
		
		if ( $coursetype->save() )
			return Redirect::route('coursetypes.index')->with('message', 'Kurstyp erfolgreich erstellt!');
		else
			return Redirect::route('coursetypes.index')->withInput()->withErrors( $coursetype->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function show(CourseType $coursetype)
	{	
		$this->layout->content = View::make('coursetypes.show', compact('coursetype'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function update(CourseType $coursetype)
	{
		$input = Input::all();
		$coursetype->fill($input);
 
		if ( $coursetype->updateUniques() )
			return Redirect::route('coursetypes.show', $coursetype->id)->with('message', 'Der Kurstyp wurde aktualisiert.');
		else
			return Redirect::route('coursetypes.show', array_get($coursetype->getOriginal(), 'id'))->withInput()->withErrors( $coursetype->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function destroy(CourseType $coursetype)
	{
		$coursetype->delete();
		return Redirect::route('coursetypes.index')->with('message', 'Kurstyp erfolgreich gelöscht.');
	}

}