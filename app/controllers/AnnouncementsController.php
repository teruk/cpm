<?php

use Illuminate\Support\Facades\Redirect;
class AnnouncementsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /announcements
	 *
	 * @return Response
	 */
	public function index()
	{
		$announcements = Announcement::all();
		$this->layout->content = View::make('announcements.index', compact('announcements'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /announcements
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$announcement = new Announcement();
		
		if ($announcement->publish($input))
			return Redirect::back()->with('message', 'Ankündigung wurde erfolgreich erstellt!');

		return Redirect::back()->withInput()->withErrors($announcement->errors());
	}

	/**
	 * Display the specified resource.
	 * GET /announcements/{id}
	 *
	 * @param  int  Announcement $Announcement
	 * @return Response
	 */
	public function show(Announcement $announcement)
	{	
		$this->layout->content = View::make('announcements.show', compact('announcement'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /announcements/{id}
	 *
	 * @param  int  Announcement $Announcement
	 * @return Response
	 */
	public function update(Announcement $announcement)
	{
		$input = Input::all();
		if ($announcement->updateInformation($input))
			return Redirect::back()->with('message', 'Die Ankündigung wurde aktualisiert.');
		
		return Redirect::back()->withInput()->withErrors( $announcement->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /announcements/{id}
	 *
	 * @param  int  Announcement $Announcement
	 * @return Response
	 */
	public function destroy(Announcement $announcement)
	{
		$announcement->delete();
		return Redirect::back()->with('message', 'Die Ankündigung erfolgreich gelöscht.');
	}

}