<?php

class LecturerAssignmentController extends \BaseController {

	/**
	 * assign a lecturer to a specific planning
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function assignLecturer(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 1);

		$employee = Employee::findOrFail(Input::get('employee_id'));
		$planning->employees()->attach($employee->id, [
				'semester_periods_per_week'=> Input::get('semester_periods_per_week')
				]);

		$planninglog = new Planninglog();
		$planninglog->logAssignedPlanningEmployee($planning, $turn, $employee, Input::get('semester_periods_per_week'));

		return Redirect::back()->with('message', 'Mitarbeiter erfolgreich hinzugefügt.');
	}

	/**
	 * update an assigned lecturer
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function updateLecturer(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 1);
		// TODO check if the sum of semester periods per weeks exceeds the semester periods per week of the course
		$employee = Employee::findOrFail(Input::get('employee_id'));		

		// log
		foreach ($planning->employees as $e) {
			if ($e->id == $employee->id)
			{
				$planninglog = new Planninglog();
				$planninglog->logUpdatedPlanningEmployee($planning, $turn, $e, $Input::get('semester_periods_per_week'));
			}
		}
		// update
		$planning->employees()->updateExistingPivot($employee->id, [
			'semester_periods_per_week' => Input::get('semester_periods_per_week')
			], true);
		
		return Redirect::back()->with('message', 'Mitarbeiter erfolgreich aktualisiert.');
	}

	/**
	* delete employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function detachLecturer(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 1);

		// detach
		$employee = Employee::findOrFail(Input::get('employee_id'));
		$planning->employees()->detach($employee->id);

		// log
		$planninglog = new Planninglog();
		$planninglog->logDetachedPlanningEmployee($planning, $turn, $employee);
		
		return Redirect::back()->with('message', 'Mitarbeiter erfolgreich entfernt.');
	}

	/**
	* copy lecturer to current planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function copyLecturer(Turn $turn, Planning $planning)
	{
		$source_planning = Planning::findOrFail(Input::get('source_planning_id'));
		$all_employees_copied = true;
		$message = "";
		// if size of $planning->employee is higher than 0, check for duplicates
		if ($planning->employees()->count() > 0)
		{
			$current_employee_ids = $this->getIds($planning->employees);

			foreach ($source_planning->employees as $spe) {
				if (!in_array($spe->id, $current_employee_ids))
				{
					$planning->employees()->attach($spe->id, array('semester_periods_per_week' => $spe->pivot->semester_periods_per_week));
					// log
					$planninglog = new Planninglog();
					$planninglog->logCopiedPlanningEmployee($planning, $turn, $spe);
				}
				else
				{
					$all_employees_copied = false;
					$message .= $spe->firstname.' '.$spe->name.'; ';
				}
			}
		}
		else
		{
			foreach ($source_planning->employees as $e) {
				$planning->employees()->attach($e->id, array('semester_periods_per_week' => $e->pivot->semester_periods_per_week));
				// log
				$planninglog = new Planninglog();
				$planninglog->logCopiedPlanningEmployee($planning, $turn, $e);
			}
		}
		if ($all_employees_copied)
			return Redirect::back()->with('message', 'Mitarbeiter wurden erfolgreich übernommen.');
		else
			return Redirect::back()->with('error', 'Es konnten nicht alle Mitarbeiter übernommen werden: '.$message);
	}
}
