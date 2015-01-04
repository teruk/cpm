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
		{
			Flash::success('Kurstyp erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($coursetype->errors());
		return Redirect::back()->withInput();
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
		{
			Flash::success('Der Kurstyp wurde aktualisiert.');
			return Redirect::route('coursetypes.show', $coursetype->id);
		}
		
		Flash::error($coursetype->errors());
		return Redirect::route('coursetypes.show', array_get($coursetype->getOriginal(), 'id'))->withInput();
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
		Flash::success('Kurstyp erfolgreich gelöscht.');
		return Redirect::back();
	}

}