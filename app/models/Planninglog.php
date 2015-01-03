<?php

use LaravelBook\Ardent\Ardent;

define("ACTION_TYPE_ADDING", 0);
define('ACTION_TYPE_UPDATING', 1);
define('ACTION_TYPE_DELETING', 2);

define("CATEGORY_PLANNING", 0);
define('CATEGORY_PLANNING_EMPLOYEE', 1);
define('CATEGORY_PLANNING_ROOM', 2);
define('CATEGORY_PLANNING_EXAM', 3);
define('CATEGORY_PLANNING_STATUS', 4);

class Planninglog extends Ardent {
	
	protected $fillable = ['planning_id', 'action','category', 'username', 'action_type', 'turn_id'];

	public static $rules = array(
			'planning_id' => 'required',
			'action' => 'required',
			'category' => 'required',
			'username' => 'required',
			'turn_id' => 'required',
			'action_type' => 'required',
	);

	/**
	* Adds a planning log entry to the db
	* @param Planning $planning
	* @param $category integer
	* @param $action integer
	* @param $action_type integer
	*/
	public function saveLog(Planning $planning, $category, $action, $action_type)
	{
		$this->planning_id = $planning->id;
		$this->turn_id = $planning->turn_id;
		$this->category = $category;
		$this->action_type = $action_type;
		$this->username = Entrust::user()->name;
		$this->action = $action;
		$this->save();
	}

	/**
	 * create log entry for the added planning
	 * @param Planning $planning [description]
	 * @param Turn     $turn     [description]
	 */
	public function logCreatedPlanning(Planning $planning, Turn $turn)
	{
		$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
				$planning->room_preference;

		$this->saveLog($planning, CATEGORY_PLANNING, $action, ACTION_TYPE_ADDING);
	}

	/**
	 * create log entry for updated planning
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @return [type]             [description]
	 */
	public function logUpdatedPlanning(Planning $planning, Turn $turn)
	{
		$action = "Planung aktualisiert (".$turn->name." ".$turn->year."): ".
					$planning->course_number." ".$planning->course_title." (".$planning->course_title."); Gruppen-Nr. ".
					$planning->group_number."; Sprache ".Config::get('constants.language')[$planning->language]."; AB: ".Config::get('constants.pl_rgstatus')[$planning->researchgroup_status]."; VS: ".
					Config::get('constants.pl_board_status')[$planning->board_status]."; Bemerkung: ".$planning->comment."; Raumwunsch: ".$planning->room_preference;

		$this->saveLog($planning, CATEGORY_PLANNING, $action, ACTION_TYPE_UPDATING);
	}

	/**
	 * create log entry for deleted planning
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @return [type]             [description]
	 */
	public function logDeletedPlanning(Planning $planning, Turn $turn)
	{
		$action = "Planung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number;

		$this->saveLog($planning, CATEGORY_PLANNING, $action, ACTION_TYPE_DELETING);
	}

	/**
	 * create log entry for copied planning
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @return [type]             [description]
	 */
	public function logCopiedPlanning(Planning $planning, Turn $turn)
	{
		$action = "Planung kopiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
					$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
					$planning->room_preference;

		$this->saveLog($planning, CATEGORY_PLANNING, $action, ACTION_TYPE_ADDING);
	}

	/**
	 * create log entry for updated exam type
	 * @param  Planning $planning    [description]
	 * @param  Turn     $turn        [description]
	 * @param  [type]   $oldExamType [description]
	 * @param  [type]   $newExamType [description]
	 * @return [type]                [description]
	 */
	public function logUpdatedPlanningExam(Planning $planning, Turn $turn, $oldExamType, $newExamType)
	{
		$action = "Modulabschlussart aktualisiert (".$turn->name." ".$turn->year."): ".
					$planning->course->module->short." ".$planning->course->module->name."; Abschluss: ".
					Config::get('constants.exam_type')[$oldExamType]." -> ".Config::get('constants.exam_type')[$newExamType];

		$this->saveLog($planning, CATEGORY_PLANNING_EXAM, $action, ACTION_TYPE_UPDATING);
	}

	/**
	 * create log entry for planning status update
	 * @param  Planning $planning               [description]
	 * @param  Turn     $turn                   [description]
	 * @param  [type]   $oldBoardStatus         [description]
	 * @param  [type]   $oldResearchgroupStatus [description]
	 * @return [type]                           [description]
	 */
	public function logUpdatedPlanningStatus(Planning $planning, Turn $turn, $oldBoardStatus, $oldResearchgroupStatus)
	{
		$action = "Planung aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number."; AB: ".
				Config::get('constants.pl_rgstatus')[$oldResearchgroupStatus]."->".Config::get('constants.pl_rgstatus')[$planning->researchgroup_status]."; VS: ".
				Config::get('constants.pl_board_status')[$oldBoardStatus]."->".Config::get('constants.pl_board_status')[$planning->board_status];

		$this->saveLog($planning, CATEGORY_PLANNING_STATUS, $action, ACTION_TYPE_UPDATING);
	}

	/**
	 * create log entry for planning employee assigning
	 * 
	 * @param  Planning $planning               [description]
	 * @param  Turn     $turn                   [description]
	 * @param  Employee $employee               [description]
	 * @param  [type]   $semesterPeriodsPerWeek [description]
	 * @return [type]                           [description]
	 */
	public function logAssignedPlanningEmployee(Planning $planning, Turn $turn, Employee $employee, $semesterPeriodsPerWeek)
	{
		$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".
				$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".
				$planning->group_number." ".$employee->firstname.' '.$employee->name.' ('.$semesterPeriodsPerWeek.' SWS)';

		$this->saveLog($planning, CATEGORY_PLANNING_EMPLOYEE, $action, ACTION_TYPE_ADDING);
	}

	/**
	 * create log entry for planning employee update
	 * @param  Planning $planning               [description]
	 * @param  Turn     $turn                   [description]
	 * @param  Employee $employee               [description]
	 * @param  [type]   $semesterPeriodsPerWeek [description]
	 * @return [type]                           [description]
	 */
	public function logUpdatedPlanningEmployee(Planning $planning, Turn $turn, Employee $employee, $semesterPeriodsPerWeek)
	{
		$action = "Mitarbeiter aktualisiert (".$turn->name." ".$turn->year."): ".
				$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".
				$planning->group_number." ".$employee->firstname.' '.$employee->name.' ('.$e->pivot->semester_periods_per_week.' SWS -> '.
				$semesterPeriodsPerWeek.' SWS)';

		$this->saveLog($planning, CATEGORY_PLANNING_EMPLOYEE, $action, ACTION_TYPE_UPDATING);
	}

	/**
	 * create log entry for planning employee detaching
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  Employee $employee [description]
	 * @return [type]             [description]
	 */
	public function logDetachedPlanningEmployee(Planning $planning, Turn $turn, Employee $employee)
	{
		$action = "Mitarbeiterzuordnung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name;

		$this->saveLog($planning, CATEGORY_PLANNING_EMPLOYEE, $action, ACTION_TYPE_DELETING);
	}

	/**
	 * create entry log for planning employee copying
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  Employee $employee [description]
	 * @return [type]             [description]
	 */
	public function logCopiedPlanningEmployee(Planning $planning, Turn $turn, Employee $employee)
	{
		$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.
				$employee->name.' ('.$employee->pivot->semester_periods_per_week.' SWS)';

		$this->saveLog($planning, CATEGORY_PLANNING_EMPLOYEE, $action, ACTION_TYPE_ADDING);
	}

	/**
	 * create entry log for planning room assignment
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  Room     $room     [description]
	 * @param  [type]   $input    [description]
	 * @return [type]             [description]
	 */
	public function logAssignedPlanningRoom(Planning $planning, Turn $turn, Room $room, $input)
	{
		$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
				$room->name.' ('.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.
					substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';

		$this->saveLog($planning, CATEGORY_PLANNING_ROOM, $action, ACTION_TYPE_ADDING);
	}

	/**
	 * create entry log for planning room update
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  Room     $room     [description]
	 * @param  [type]   $input    [description]
	 * @return [type]             [description]
	 */
	public function logUpdatedPlanningRoom(Planning $planning, Turn $turn, Room $room, $input, $oldRoom)
	{
		$action = "Raum aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
				$oldRoom->name.' -> ('.$room->name.') ('.Config::get('constants.weekdays_short')[$input['weekday_old']].', '.
					substr($input['start_time_old'],0,5).'-'.substr($input['end_time_old'],0,5).') -> ('.Config::get('constants.weekdays_short')[$input['weekday']].', '.
					substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';

		$this->saveLog($planning, CATEGORY_PLANNING_ROOM, $action, ACTION_TYPE_UPDATING);
	}

	/**
	 * create entry log for planning room detachment
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  Room     $room     [description]
	 * @param  [type]   $input    [description]
	 * @return [type]             [description]
	 */
	public function logDetachedPlanningRoom(Planning $planning, Turn $turn, Room $room, $input)
	{
		$action = "Raumzuordnung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
				$room->name.' ('.Config::get('constants.weekdays_short')[$input['weekday']].', '.
					substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';

		$this->saveLog($planning, CATEGORY_PLANNING_ROOM, $action, ACTION_TYPE_DELETING);
	}

	/**
	 * create log entry for planning room copying
	 * @param  Planning $planning     [description]
	 * @param  Turn     $turn         [description]
	 * @param  Room     $room         [description]
	 * @param  [type]   $planningRoom [description]
	 * @return [type]                 [description]
	 */
	public function logCopiedPlanningRoom(Planning $planning, Turn $turn, Room $room, $planningRoom)
	{
		$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
					$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
					$room->name.' ('.Config::get('constants.weekdays_short')[$planningRoom->weekday].', '.
						substr($planningRoom->start_time,0,5).'-'.substr($planningRoom->end_time,0,5).')';

		$this->saveLog($planning, CATEGORY_PLANNING_ROOM, $action, ACTION_TYPE_ADDING);
	}
}