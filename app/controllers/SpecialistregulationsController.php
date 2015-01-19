<?php

class SpecialistregulationsController extends \BaseController {

	/**
	 * show specialist regulation edit form
	 * @param  Degreecourse         $degreecourse         [description]
	 * @param  Specialistregulation $specialistregulation [description]
	 * @return [type]                                     [description]
	 */
	public function edit(Degreecourse $degreecourse, Specialistregulation $specialistregulation)
	{
		$turns = Turn::getList();
		return View::make('degreecourses.editSpecialistregulation', compact('degreecourse', 'specialistregulation', 'turns'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$specialistregulation = new Specialistregulation();

		$numberOfDuplicates = Specialistregulation::where('degreecourse_id', '=', $degreecourse->id)
													->where('turn_id', '=', $input['turn_id'])
													->count();
		if ($numberOfDuplicates == 0)
			$specialistregulation =  $this->save($specialistregulation, $input, 'Die Fachspezischen Bestimmungen wurden erfolgreich gespeichert!');
		else
			Flash::error('Die Fachspezifischen Bestimmungen (FSB) konnten nicht gespeichert werden, 
							da für dieses Startsemester schon eine FSB existiert.');

		return Redirect::back()->withInput();
	}

	/**
	 * update Information of a specialist regulation
	 * @param  Degreecourse         $degreecourse         [description]
	 * @param  Specialistregulation $specialistregulation [description]
	 * @return [type]                                     [description]
	 */
	public function update(Degreecourse $degreecourse, Specialistregulation $specialistregulation)
	{
		$input = Input::all();
		$input = array_add($input,'degreecourseId',$degreecourse->id);

		$numberOfDuplicates = Specialistregulation::where('id', '!=', $specialistregulation->id)
													->where('degreecourse_id', '=', $degreecourse->id)
													->where('turn_id', '=', $input['turnId'])
													->count();
		if ($numberOfDuplicates == 0)
			$specialistregulation = $this->save($specialistregulation, $input, 'Die Fachspezischen Bestimmungen wurden erfolgreich aktualisiert!');
		else
			Flash::error('Die Fachspezifischen Bestimmungen (FSB) konnten nicht aktualisiert werden, 
							da für dieses Startsemester schon eine FSB besteht!');

		return Redirect::back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Degreecourse $degreecourse, Specialistregulation $specialistregulation)
	{
		if ($specialistregulation->delete()) 
			Flash::success('Die Fachspezifische Bestimmungen wurden erfolgreich gelöscht!');
		else
			Flash::error($specialistregulation->errors());

		return Redirect::back();
	}

	/**
	 * validates and if successful, save the specialist regulation
	 * @param  Specialistregulation $specialistregulation [description]
	 * @param  [type]               $input                [description]
	 * @param  string               $successMessage       [description]
	 * @return [type]                                     [description]
	 */
	private function save(Specialistregulation $specialistregulation, $input, $successMessage = "Foobar")
	{
		$specialistregulation->setAttributes($input);

		if (!array_key_exists('active', $input))
			$specialistregulation->setSpecialistregulationInactive();
		else
			$specialistregulation->setSpecialistregulationActive();

		$validator = Validator::make($specialistregulation->toArray(), $specialistregulation->rules);

		if ($validator->fails()) {
			Flash::error($validator->messages());
		} else {
			$specialistregulation->save();
			Flash::success($successMessage);
		}

		return $specialistregulation;
	}

}
