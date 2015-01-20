<?php

class LecturerAssignmentController extends \BaseController 
{

	/**
	 * show currently assigned lecturer and assign form
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function showLecturer(Turn $turn, Planning $planning)
	{
		// check if current user is allowed to access this planning
		if (!$this->checkPlanningResponsibility($turn, $planning)) {
			Flash::error('Sie haben keine Zugriffsberechtigung für diese Planung!');
			return Redirect::route('home');
		}

		$course = Course::findOrFail($planning->course_id);

		// get only employee which belong to the assigned research groups
		$employees = [];
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$employees = Employee::getList();
		else {
			$researchgroupIds = Entrust::user()->getResearchgroupIds();
			$rawEmployees = Employee::whereIn('researchgroup_id',$researchgroupIds)
								->orderBy('researchgroup_id', 'ASC')
								->orderBy('name', 'ASC')
								->get();

			// make the list presentable
			foreach ($rawEmployees as $employee) {
				$employees = array_add($employees, $employee->id, $employee->title.' '.$employee->firstname.' '.$employee->name);
			}
		}
		/** TODO: extract the already assigned lecturer from employees array */

		$oldplannings = Planning::oldPlannings($planning, $turn)->get();
		if (sizeof($oldplannings) == 0)
			$oldplannings = array();

		$relatedplannings = Planning::relatedPlannings($planning, $course)->get();

		if (sizeof($relatedplannings) == 0)
			$relatedplannings = array();

		$this->layout->content = View::make('plannings.editLecturer', compact('turn', 'planning', 'course', 'employees', 'oldplannings', 'relatedplannings'));
	}

	/**
	 * assign a lecturer to a specific planning
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function assignLecturer(Turn $turn, Planning $planning)
	{
		$employee = Employee::findOrFail(Input::get('employee_id'));
		
		$planning->employees()->attach($employee->id, [
				'semester_periods_per_week'=> Input::get('semester_periods_per_week')
				]);

		$planninglog = new Planninglog();
		$planninglog->logAssignedPlanningEmployee($planning, $turn, $employee, Input::get('semester_periods_per_week'));

		Flash::success('Mitarbeiter erfolgreich hinzugefügt.');
		return Redirect::back();
	}

	/**
	 * update an assigned lecturer
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function updateLecturer(Turn $turn, Planning $planning)
	{
		// TODO check if the sum of semester periods per weeks exceeds the semester periods per week of the course
		$employee = Employee::findOrFail(Input::get('employee_id'));		

		// log
		foreach ($planning->employees as $e) {
			if ($e->id == $employee->id) {
				$planninglog = new Planninglog();
				$planninglog->logUpdatedPlanningEmployee($planning, $turn, $e, Input::get('semester_periods_per_week'));
			}
		}
		// update
		$planning->employees()->updateExistingPivot($employee->id, [
			'semester_periods_per_week' => Input::get('semester_periods_per_week')
			], true);
		
		Flash::success('Mitarbeiter erfolgreich aktualisiert.');
		return Redirect::back();
	}

	/**
	* delete employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function detachLecturer(Turn $turn, Planning $planning)
	{
		// detach
		$employee = Employee::findOrFail(Input::get('employee_id'));
		$planning->employees()->detach($employee->id);

		// log
		$planninglog = new Planninglog();
		$planninglog->logDetachedPlanningEmployee($planning, $turn, $employee);
		
		Flash::success('Mitarbeiter erfolgreich entfernt.');
		return Redirect::back();
	}

	/**
	* copy lecturer to current planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function copyLecturer(Turn $turn, Planning $planning)
	{
		$sourcePlanning = Planning::findOrFail(Input::get('source_planning_id'));
		$allEmployeesCopied = true;
		$message = "";
		// if size of $planning->employee is higher than 0, check for duplicates
		if ($planning->employees()->count() > 0) {
			$currentEmployeeIds = array_fetch($planning->employees->toArray(), 'id');

			foreach ($sourcePlanning->employees as $sourcePlanningEmployee) {
				if (!in_array($sourcePlanningEmployee->id, $currentEmployeeIds)) {
					$planning->employees()->attach(
						$sourcePlanningEmployee->id, 
						array('semester_periods_per_week' => $sourcePlanningEmployee->pivot->semester_periods_per_week
							)
						);
					// log
					$planninglog = new Planninglog();
					$planninglog->logCopiedPlanningEmployee($planning, $turn, $sourcePlanningEmployee);
				} else {
					$allEmployeesCopied = false;
					$message .= $sourcePlanningEmployee->firstname.' '.$sourcePlanningEmployee->name.'; ';
				}
			}
		} else {
			foreach ($sourcePlanning->employees as $e) {
				$planning->employees()->attach(
					$e->id, 
					array('semester_periods_per_week' => $e->pivot->semester_periods_per_week)
					);
				// log
				$planninglog = new Planninglog();
				$planninglog->logCopiedPlanningEmployee($planning, $turn, $e);
			}
		}

		if ($allEmployeesCopied) {
			Flash::success('Mitarbeiter wurden erfolgreich übernommen.');
			return Redirect::back();
		}
		
		Flash::error('Es konnten nicht alle Mitarbeiter übernommen werden: '.$message);
		return Redirect::back();
	}
}
