<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class RoomsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /rooms
	 *
	 * @return Response
	 */
	public function index()
	{
		$rooms = Room::all();
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$this->layout->content = View::make('rooms.index', compact('rooms','listofroomtypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /rooms
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$room = new Room($input);

		if (Input::get('beamer')==1)
			$room->beamer = Input::get('beamer');
		else 
			$room->beamer = 0;

		if (Input::get('blackboard')==1)
			$room->blackboard = Input::get('blackboard');
		else
			$room->blackboard = 0;

		if (Input::get('overheadprojector')==1)
			$room->overheadprojector = Input::get('overheadprojector');
		else
			$room->overheadprojector = 0;

		if (Input::get('accessible')==1)
			$room->accessible = Input::get('accessible');
		else
			$room->accessible = 0;
		
		if ( $room->save() )
			return Redirect::route('rooms.index')->with('message', 'Raum erfolgreich erstellt!');
		else
			return Redirect::route('rooms.index')->withInput()->withErrors( $room->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function show(Room $room)
	{	
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$this->layout->content = View::make('rooms.show', compact('room', 'listofroomtypes'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function update(Room $room)
	{
		$input = Input::all();
		$room->fill($input);
		if (Input::get('beamer')==1)
			$room->beamer = Input::get('beamer');
		else
			$room->beamer = 0;

		if (Input::get('blackboard')==1)
			$room->blackboard = Input::get('blackboard');
		else
			$room->blackboard = 0;

		if (Input::get('overheadprojector')==1)
			$room->overheadprojector = Input::get('overheadprojector');
		else
			$room->overheadprojector = 0;

		if (Input::get('accessible')==1)
			$room->accessible = Input::get('accessible');
		else
			$room->accessible = 0;
 
		if ( $room->updateUniques() )
			return Redirect::route('rooms.show', $room->id)->with('message', 'Der Raum wurde aktualisiert.');
		else
			return Redirect::route('rooms.show', array_get($room->getOriginal(), 'id'))->withInput()->withErrors( $room->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function destroy(Room $room)
	{
		$room->delete();
		return Redirect::back()->with('message', 'Raum erfolgreich gelöscht.');
	}
}