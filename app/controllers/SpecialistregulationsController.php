<?php

class SpecialistregulationsController extends \BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		if (!Input::has('active'))
			$input['active'] = 0;

		$specialistregulation = new Specialistregulation();
		$specialistregulation->setAttributes($input);

		$validator = Validator::make($specialistregulation, $rules);

		if ($validator->fails()) {
			Flash::error($validator->messages());
		} else {
			$specialistregulation->save();
			Flash::success('Fachspezifische Bestimmung erfolgreich erstellt.');
		}
		
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
