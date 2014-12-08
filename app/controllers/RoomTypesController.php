<?php

use Illuminate\Support\Facades\Redirect;
class RoomTypesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /roomtypes
	 *
	 * @return Response
	 */
	public function index()
	{
		$roomtypes = RoomType::all();
		$this->layout->content = View::make('roomtypes.index', compact('roomtypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /roomtypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
// 		$this->layout->content = View::make('degree_courses.index');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /roomtypes
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$roomtype = new RoomType($input);
		
		if ( $roomtype->save() )
			return Redirect::route('roomtypes.index')->with('message', 'Raumtyp erfolgreich erstellt!');
		else
			return Redirect::route('roomtypes.index')->withInput()->withErrors( $roomtype->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /roomtypes/{id}
	 *
	 * @param  int  RoomType $roomtype
	 * @return Response
	 */
	public function show(RoomType $roomtype)
	{	
		$this->layout->content = View::make('roomtypes.show', compact('roomtype'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /roomtypes/{id}
	 *
	 * @param  int  RoomType $roomtype
	 * @return Response
	 */
	public function update(RoomType $roomtype)
	{
		$input = Input::all();
		$roomtype->fill($input);
 
		if ( $roomtype->updateUniques() )
			return Redirect::route('roomtypes.show', $roomtype->id)->with('message', 'Der Raumtyp wurde aktualisiert.');
		else
			return Redirect::route('roomtypes.show', array_get($roomtype->getOriginal(), 'id'))->withInput()->withErrors( $roomtype->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /roomtypes/{id}
	 *
	 * @param  int  RoomType $roomtype
	 * @return Response
	 */
	public function destroy(RoomType $roomtype)
	{
		$roomtype->delete();
		return Redirect::route('roomtypes.index')->with('message', 'Raumtyp erfolgreich gelöscht.');
	}

}