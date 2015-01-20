<?php

use Illuminate\Support\Facades\Redirect;
class appointeddaysController extends BaseController 
{

	/**
	 * Display a listing of the resource.
	 * GET /appointeddays
	 *
	 * @return Response
	 */
	public function index()
	{
		$appointeddays = Appointedday::all();
		return View::make('appointeddays.index', compact('appointeddays'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /appointeddays
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$appointedday = new Appointedday();

		if ($appointedday->publish($input)) {
			Flash::success('Der Termin wurde erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($appointedday->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /appointeddays/{id}
	 *
	 * @param  int  appointedday $appointedday
	 * @return Response
	 */
	public function edit(Appointedday $appointedday)
	{	
		if (Entrust::hasRole('Admin') || Entrust::can('edit_appointedday'))
			return View::make('appointeddays.show', compact('appointedday'));

		Flash::error('Zugriff verweigert!');
		return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /appointeddays/{id}
	 *
	 * @param  int  appointedday $appointedday
	 * @return Response
	 */
	public function update(Appointedday $appointedday)
	{
		$input = Input::all();
 
		if ( $appointedday->updateInformation($input) ) {
			Flash::success('Der Termin wurde aktualisiert.');
			return Redirect::back();
		}

		Flash::error($appointedday->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /appointeddays/{id}
	 *
	 * @param  int  appointedday $appointedday
	 * @return Response
	 */
	public function destroy(Appointedday $appointedday)
	{
		$appointedday->delete();
		Flash::success('Der Termin wurde erfolgreich gelöscht.');
		return Redirect::back();
	}
}
