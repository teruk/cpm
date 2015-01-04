<?php

class CopyPlanningsController extends \BaseController {

	/**
	 * copy selected plannings
	 * 
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function copy(Turn $turn)
	{
		$input = Input::all();
		if (array_key_exists('selected', $input))
		{
			$plannings = Planning::whereIn('id', $input['selected'])->get();
		}
		else
		{
			$predecessorturn = $turn->getPredecessor();
			if (is_numeric($predecessorturn))
			{
				Flash::error("Es existiert kein vorheriges Semester zum Kopieren!");
				return Redirect::back();
			}

			$plannings = $this->getTurnPlannings($predecessorturn->id);
		}

		$result = $this->copyPlannings($turn, $plannings, $input);
		if ($result['copyall'])
		{
			Flash::success('Alle Veranstaltungen wurden erfolgreich kopiert.');
			return Redirect::route('plannings.indexTurn', $turn->id);
		}

		Flash::error($result['warnmessage']);
		return Redirect::route('plannings.indexTurn', $turn->id);
	}

	/**
	 * fetch specific plannings from a specific turn for a user
	 * @param  [type] $turnId [description]
	 * @return [type]         [description]
	 */
	private function getTurnPlannings($turnId)
	{
		$plannings = [];
		// get all courses of the specific turn
		if (Entrust::hasRole('Admin') || Entrust::hasRole('Lehrplanung') ) // role Lehrplanung has to be changed to a permission
			$plannings = Planning::where('turn_id','=',$turnId)->get();
		else
		{
			$rgIds = Entrust::user()->researchgroupIds();
			$plannings = DB::table('plannings')
				->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
				->join('employees', 'employees.id','=','employee_planning.employee_id')
				->join('researchgroups', 'researchgroups.id', '=', 'employees.researchgroup_id')
				->select('plannings.id')
				->whereIn('researchgroups.id',$rgIds)
				->where('plannings.turn_id','=', $turnId)
				->get();

			$planning_ids = [];
			if (sizeof($plannings) > 0)
			{
				foreach ($plannings as $p) {
					array_push($planning_ids, $p->id);
				}
			}
			else
				$plannings = array();

			$planningUser = Planning::where('user_id','=',Entrust::user()->id)->where('turn_id','=',$turnId)->get();

			foreach ($planningUser as $p) {
				if (!array_key_exists($p->id, $planning_ids))
					array_push($planning_ids, $p->id);
			}

			if (sizeof($planning_ids) > 0)
				$plannings = Planning::related($planning_ids)->get();
		}

		return $plannings;
	}

	/**
	* copy given plannings
	* @param Turn $turn
	* @param array $plannings
	* @param boolean $copy_employees
	* @param boolean $copy_comments
	* @param boolean $copy_room_preferences
	*/
	private function copyPlannings(Turn $turn, $plannings, $options)
	{
		$copyall = true;
		$warnmessage = "Es konnten nicht alle Veranstaltungen aus dem letzten Semester kopiert werden,
					da diese bereits im aktuellen Semester geplant wurden.<br> Folgende Veranstaltungen konnten nicht kopiert werden: ";
		foreach ($plannings as $planning)
		{
			$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');

			if (Planning::checkDuplicate($planning->course_id, $turn->id, $planning->group_number)->count() == 0)
			{
				// if not, copy it
				// Saving the course for the new turn
				$planningnew = new Planning;
				if ($planningnew->copy($planning, $turn, $options))
				{
					// log
					$planninglog = new Planninglog();
					$planninglog->logCopiedPlanning($planningnew, $turn);
					
					if (array_key_exists('employees', $options))
					{
						// getting the employees from employee_turn from the old course turn and copy it
						if ($planning->employees->count() > 0)
						{
							// copy every employee
							foreach ($planning->employees as $employee)
							{
								$planningnew->employees()->attach($employee->id, array(
										'semester_periods_per_week' => $employee->pivot->semester_periods_per_week,
										'created_at' => new Datetime,
										'updated_at' => new Datetime
								));
								
								$planninglog = new Planninglog();
								$planninglog->logCopiedPlanningEmployee($planningnew, $turn, $employee);
							}
						}
					}
					
					// getting exam type
					$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
					$turn->saveExam($planning->course->module);
				}
				else
				{
					// failed to save the new planning
					$copyall = false;
					$course = Course::findOrFail($planning->course_id);
					$warnmessage .= $course->course_number." (".$planning->group_number.");";
				}
			}
			else
			{
				// if yes, do nothing
				$copyall = false;
				$course = Course::findOrFail($planning->course_id);
				$warnmessage .= $course->course_number." (".$planning->group_number.");";
			}
		}
		$result = array();
		$result['copyall'] = $copyall;
		$result['warnmessage'] = $warnmessage;
		return $result;
	}
}