<?php

use Illuminate\Support\Facades\Redirect;
class appointeddaysController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /appointeddays
	 *
	 * @return Response
	 */
	public function index()
	{
		$appointeddays = Appointedday::all();
		$this->layout->content = View::make('appointeddays.index', compact('appointeddays'));
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

		if ($appointedday->publish($input))
			return Redirect::back()->with('message', 'Der Termin wurde erfolgreich erstellt!');

		return Redirect::back()->withInput()->withErrors( $appointedday->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /appointeddays/{id}
	 *
	 * @param  int  appointedday $appointedday
	 * @return Response
	 */
	public function show(Appointedday $appointedday)
	{	
		if (Entrust::hasRole('Admin') || Entrust::can('edit_appointedday'))
			$this->layout->content = View::make('appointeddays.show', compact('appointedday'));
		else
			return Redirect::back()->with('error','Zugriff verweigert!');
	}

	/**
	 * Display the specified resource.
	 * GET /appointeddays/{id}
	 *
	 * @param  int  appointedday $appointedday
	 * @return Response
	 */
	public function info(Appointedday $appointedday)
	{	
		$this->layout->content = View::make('appointeddays.info', compact('appointedday'));
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
 
		if ( $appointedday->updateInformation($input) )
			return Redirect::back()->with('message', 'Der Termin wurde aktualisiert.');

		return Redirect::back()->withInput()->withErrors( $appointedday->errors() );
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
		return Redirect::back()->with('message', 'Der Termin wurde erfolgreich gelöscht.');
	}

}