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
		$room = new Room();

		if ($room->register($input))
			return Redirect::back()->with('message', 'Raum erfolgreich erstellt!');

		return Redirect::back()->withInput()->withErrors( $room->errors() );
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

		if ( $room->updateInformation($input) )
			return Redirect::back()->with('message', 'Der Raum wurde aktualisiert.');
		
		return Redirect::back()->withInput()->withErrors( $room->errors() );
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