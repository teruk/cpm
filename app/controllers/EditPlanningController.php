<?php

class EditPlanningController extends \BaseController {

	/**
	 * display general planning information
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function showInformation(Turn $turn, Planning $planning)
	{
		// check if current user is allowed to access this planning
		if (!$this->checkPlanningResponsibility($turn, $planning))
		{
			Flash::error('Sie haben keine Zugriffsberechtigung für diese Planung!');
			return Redirect::route('home');
		}

		$course = Course::findOrFail($planning->course_id);

		$oldplannings = Planning::oldPlannings($planning, $turn)->get();
		if (sizeof($oldplannings) == 0)
			$oldplannings = array();

		$relatedplannings = Planning::relatedPlannings($planning, $course)->get();

		if (sizeof($relatedplannings) == 0)
			$relatedplannings = array();

		$this->layout->content = View::make('plannings.editPlanning', compact('turn', 'planning', 'course', 'oldplannings', 'relatedplannings'));
	}

	/**
	* update a specific planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function updateInformation(Turn $turn, Planning $planning)
	{
		$duplicate = false;
		$input = Input::all();
		// check if the group number has changed
		if ($input['group_number'] != $planning->group_number)
		{
			// number has changed, check for a duplicate
			if (Planning::checkDuplicate($planning->course_id, $turn->id, $input['group_number'])->count() == 0)
				$planning->group_number = $input['group_number'];
			else
				$duplicate = true;
		}

		if ($planning->updateInformation($input))
		{
			// updating comment and room preferences to all related plannings in the same turn
			Planning::where('turn_id','=',$turn->id)->where('course_number','=',$planning->course_number)->update(array(
				'comment' => $planning->comment, 'room_preference' => $planning->room_preference));
			// log
			$planninglog = new Planninglog();
			$planninglog->logUpdatedPlanning($planning, $turn);

			if (!$duplicate)
			{
				Flash::success('Veranstaltung erfolgreich aktualisiert.');
				return Redirect::back();
			}
			
			Flash::message('Alle Informationen bis auf die Gruppen-Nr konnten aktualisiert werden. Die Gruppen-Nr existiert jedoch bereits schon.');
			return Redirect::back();
		}

		Flash::error($planning->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * show planning logs to the specific planning
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function showProtocol(Turn $turn, Planning $planning)
	{
		// check if current user is allowed to access this planning
		if (!$this->checkPlanningResponsibility($turn, $planning))
		{
			Flash::error('Sie haben keine Zugriffsberechtigung für diese Planung!');
			return Redirect::route('home');
		}

		// get the planning logs for this planning
		$planninglog = Planninglog::where('planning_id','=', $planning->id)->orderBy('created_at', 'DESC')->get();

		$course = Course::findOrFail($planning->course_id);

		$this->layout->content = View::make('plannings.showProtocol', compact('turn', 'planning', 'course', 'planninglog'));
	}

	/**
	 * show exam form
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function showExam(Turn $turn, Planning $planning)
	{
		// check if current user is allowed to access this planning
		if (!$this->checkPlanningResponsibility($turn, $planning))
		{
			Flash::error('Sie haben keine Zugriffsberechtigung für diese Planung!');
			return Redirect::route('home');
		}
		
		$course = Course::findOrFail($planning->course_id);

		// get exam type for this semester
		$exam = DB::table('module_turn')
					->select('exam')
					->where('turn_id', '=', $turn->id)
					->where('module_id', '=', $course->module->id)
					->first();

		$this->layout->content = View::make('plannings.editExam', compact('turn', 'planning', 'course', 'exam'));
	}

	/**
	 * update the exam type for the module in the current turn
	 * 
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function updateExam(Turn $turn, Planning $planning)
	{
		foreach ($turn->modules as $m) {
			if ($m->id == Input::get('module_id'))
				$oldExamType = $m->pivot->exam;
		}
		if ($oldExamType != Input::get('exam_type'))
		{
			$turn->modules()->updateExistingPivot(Input::get('module_id'), array('exam' => Input::get('exam_type'), 'updated_at' => new Datetime));

			// log
			$planninglog = new Planninglog();
			$planninglog->logUpdatedPlanningExam($planning, $turn, $oldExamType, Input::get('exam_type'));

			Flash::success('Modulabschluss erfolgreich aktualisiert.');
			return Redirect::back();
		}

		Flash::message('Keine Änderungen registiert.');
		return Redirect::back();
	}

}
