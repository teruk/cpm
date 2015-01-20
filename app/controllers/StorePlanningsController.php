<?php

class StorePlanningsController extends \BaseController 
{

	/**
	 * store a course
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function store(Turn $turn)
	{
		$input = Input::all();
		$course = Course::findOrFail($input['course_id']);

		if (Planning::checkDuplicate($course->id, $turn->id, $input['group_number'])->count() == 0) {
			$planning = new Planning();
			$planning->store($turn, $input, $course);

			if ($planning->save()) {
				$turn->saveExam($course->module);
				//log
				$planninglog = new Planninglog();
				$planninglog->logCreatedPlanning($planning, $turn);

				Flash::success('Veranstaltung '.$planning->course_title.' erfolgreich erstellt.');
				return Redirect::back();
			}
			
			Flash::error($planning->errors());
			return Redirect::back()->withInput();

		}
		
		Flash::error('Fehler: Diese Veranstaltung existiert schon.<br>
						Veranstaltung: '.$course->course_number.' '.$course->name.' Gruppen-Nr. '.$input['group_number'].' '.$turn->name.' '.$turn->year);
		return Redirect::back()->withInput();
	}

	/**
	 * store a module with all its courses
	 * 
	 * if a module has exercises, the number of nessesary groups will be
	 * calculate by the default number of participants per lecture and exercise
	 * 
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function storeModule(Turn $turn)
	{
		$input = Input::all();
		$module = Module::findOrFail($input['module_id']);

		$input = array_add($input, 'group_number', 1);

		$coursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		// get the lecture
		$result = Course::where('module_id','=',$module->id)->whereIn('coursetype_id',array(1))->first();

		foreach ($module->courses as $course) {
			if ($coursetypes[$course->coursetype_id] == "Vorlesung" || $coursetypes[$course->coursetype_id] == "Vorlesung + Übung") {
				$planning = new Planning;
				$input['group_number'] = 1;

				$planning->store($turn, $input, $course);
				
				if ( $planning->save() ) {
					$turn = Turn::findOrFail($turn->id);
					$turn->saveExam($course->module);
					// log
					$planninglog = new Planninglog();
					$planninglog->logCreatedPlanning($planning, $turn);
				} else {
					Flash::error($planning->course_title.' Gr.'.$planning->group_number.' konnte nicht erstellt werden. Die Generierung wurde abgebrochen.');
					Flash::error($planning->errors());
					return Redirect::back();
				}
			} else {
				$number_of_groups = ceil($result->participants/$course->participants);
				for($x = 1; $x <= $number_of_groups; $x++) {
					$planning = new Planning;
					$input['group_number'] = $x;

					$planning->store($turn, $input, $course);
					
					if ( $planning->save() ) {
						$turn = Turn::findOrFail($turn->id);
						$turn->saveExam($course->module);
						// log
						$planninglog = new Planninglog();
						$planninglog->logCreatedPlanning($planning, $turn);
					} else {
						Flash::error($planning->course_title.' Gr.'.$planning->group_number.' konnte nicht erstellt werden. Die Generierung wurde abgebrochen.');
						Flash::error($planning->errors());
						return Redirect::back();
					}
				}
			}
		}

		Flash::success('Modul '.$module->name.' ('.$module->short.') erfolgreich erstellt.');
		return Redirect::back();
	}

	/**
	 * store an individual course like seminar or practical course or project
	 * 
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function storeIndividual(Turn $turn)
	{
		$input = Input::all();
		// check for duplicates
		$course = Course::findOrFail($input['course_id']);

		$duplicate = Planning::where('course_id', '=',$course->id)
							->where('turn_id', '=', $turn->id)
							->where('course_title', '=', $input['course_title'])
							->get();

		$coursetype = CourseType::findOrFail($course->coursetype_id);

		if (sizeof($duplicate) == 0) {
			$planning = new Planning;
			$input = array_add($input, 'group_number', time());
			$input = array_add($input, 'course_number', $coursetype->short.'-'.time());

			$planning->store($turn, $input, $course);

			if ( $planning->save() ) {
				$turn->saveExam($course->module);
				// log
				$planninglog = new Planninglog();
				$planninglog->logCreatedPlanning($planning, $turn);

				Flash::success('Veranstaltung '.$planning->course_title.' erfolgreich erstellt.');
				return Redirect::back();
			}
			
			Flash::error($planning->errors());
			return Redirect::back()->withInput();
		}

		Flash::error('Fehler: Diese Veranstaltung existiert schon.<br>
						Veranstaltung: '.$coursetype->short.' '.$input['course_title'].' '.$turn->name.' '.$turn->year);
		return Redirect::back();
	}
}
