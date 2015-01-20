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
		return View::make('rooms.index', compact('rooms','listofroomtypes'));
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

		if ($room->register($input)) {
			Flash::success('Raum erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($room->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function edit(Room $room)
	{	
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		return View::make('rooms.editInformation', compact('room', 'listofroomtypes'));
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

		if ( $room->updateInformation($input) ) {
			Flash::success('Der Raum wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($room->errors());
		return Redirect::back()->withInput();
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
		Flash::success('Raum erfolgreich gelöscht.');
		return Redirect::back();
	}
}
