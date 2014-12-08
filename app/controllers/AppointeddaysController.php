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
		$appointedday = new Appointedday($input);
		$appointedday->read_more = (strlen($appointedday->content) > 120) ? substr($appointedday->content, 0, 120) : $appointedday->content;
		if (Input::get('date') != "")
		{
			$appointedday->date = Input::get('date');
		}
		
		if ( $appointedday->save() )
			return Redirect::route('appointeddays.index')->with('message', 'Der Termin wurde erfolgreich erstellt!');
		else
			return Redirect::route('appointeddays.index')->withInput()->withErrors( $appointedday->errors() );
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
		{
			$this->layout->content = View::make('appointeddays.show', compact('appointedday'));
		}
		else
		{
			return Redirect::route('home')->with('error','Zugriff verweigert!');
		}
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
		$appointedday->fill($input);
		$appointedday->read_more = (strlen($appointedday->content) > 120) ? substr($appointedday->content, 0, 120) : $appointedday->content;
		$appointedday->date = Input::get('date');
 
		if ( $appointedday->updateUniques() )
			return Redirect::route('appointeddays.show', $appointedday->id)->with('message', 'Der Termin wurde aktualisiert.');
		else
			return Redirect::route('appointeddays.show', array_get($appointedday->getOriginal(), 'id'))->withInput()->withErrors( $appointedday->errors() );
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
		return Redirect::route('appointeddays.index')->with('message', 'Der Termin wurde erfolgreich gelöscht.');
	}

}