<?php

use Illuminate\Support\Facades\Redirect;
class RoomtypesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /roomtypes
	 *
	 * @return Response
	 */
	public function index()
	{
		$roomtypes = Roomtype::all();
		$this->layout->content = View::make('roomtypes.index', compact('roomtypes'));
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
		$roomtype = new Roomtype($input);
		
		if ( $roomtype->save() )
		{
			Flash::success('Raumtyp erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($roomtype->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /roomtypes/{id}
	 *
	 * @param  int  Roomtype $roomtype
	 * @return Response
	 */
	public function show(Roomtype $roomtype)
	{	
		$this->layout->content = View::make('roomtypes.show', compact('roomtype'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /roomtypes/{id}
	 *
	 * @param  int  Roomtype $roomtype
	 * @return Response
	 */
	public function update(Roomtype $roomtype)
	{
		$input = Input::all();
		$roomtype->fill($input);
 
		if ( $roomtype->updateUniques() )
		{
			Flash::success('Der Raumtyp wurde aktualisiert.');
			return Redirect::back();
		}

		Flash::error($roomtype->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /roomtypes/{id}
	 *
	 * @param  int  Roomtype $roomtype
	 * @return Response
	 */
	public function destroy(Roomtype $roomtype)
	{
		$roomtype->delete();
		Flash::success('Raumtyp erfolgreich gelöscht.');
		return Redirect::back();
	}

}