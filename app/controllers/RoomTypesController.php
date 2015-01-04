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
		{
			Flash::success('Der Raumtyp wurde aktualisiert.');
			return Redirect::route('roomtypes.show', $roomtype->id);
		}

		Flash::error($roomtype->errors());
		return Redirect::route('roomtypes.show', array_get($roomtype->getOriginal(), 'id'))->withInput();
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
		Flash::success('Raumtyp erfolgreich gelöscht.');
		return Redirect::back();
	}

}