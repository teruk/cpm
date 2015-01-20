<?php
/*
* TODO: optimize
*/

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class PlanningsController extends BaseController 
{

	/**
	 * return planned courses by given turn
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function index(Turn $turn)
	{
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || Entrust::user()->researchgroups->count() > 0)	{
			// turn navigation
			$turnNav = $this->getTurnNav($turn);

			$plannedCourses = $turn->getMyPlannings();

			$listofcoursetypes = Coursetype::orderBy('short', 'ASC')->lists('short','id');

			// checking if the predecessor turn contains planned courses
			$predecessorturn = $turn->getPredecessor();
			$pastcourses = 0;

			if (!is_numeric($predecessorturn))
				$pastcourses = Planning::where('turn_id', '=', $predecessorturn->id)->count();

			$lists = $this->getCoursetypes($turn);
			$this->layout->content = View::make('plannings.index', compact('turnNav','plannedCourses', 'lists', 'pastcourses', 'listofcoursetypes'));
		} else {
			Flash::error('Sie besitzen nicht die nötigen Rechte, um diesen Bereich zu betreten.');
			return Redirect::back();
		}
	}
	
	/**
	 * show all plannings
	 * 
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function showall(Turn $turn)
	{
		$listofcoursetypes = Coursetype::orderBy('short', 'ASC')->lists('short','id');
		$listofturns = Turn::getAvailableTurns();
		$plannings = array();

		if (Entrust::hasRole('Admin') || Entrust::can('copy_planning_all'))
			$plannings = Planning::all();
		else {
			$planningIds = array();
			// three kinds of plannings needed to be fetched from the db
			// 1. course plannings, which were thought by members of the research group
			$researchgroupIds = Entrust::user()->getResearchgroupIds();
			// foreach (Entrust::user()->researchgroups as $rg) {
			// 	array_push($rg_ids, $rg->id);
			// }
			// 
			if (sizeof($researchgroupIds) > 0) {
				$plannedCoursesByResearchgroup = DB::table('plannings')
					->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
					->join('employees', 'employees.id','=','employee_planning.employee_id')
					->select('plannings.id')
					->whereIn('employees.researchgroup_id',$researchgroupIds)
					->get();

				if (sizeof($plannedCoursesByResearchgroup) > 0) {
					foreach ($plannedCoursesByResearchgroup as $p) {
						array_push($planningIds, $p->id);
					}
				}

				// 2. old courses plannings, which the research group is assigned to through the medium-term planning
				$plannedCoursesByMediumtermplanning = DB::table('plannings')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('mediumtermplannings','mediumtermplannings.module_id','=','courses.module_id')
					->join('employee_mediumtermplanning','mediumtermplannings.id','=','employee_mediumtermplanning.mediumtermplanning_id')
					->join('employees', 'employees.id','=','employee_mediumtermplanning.employee_id')
					->select('plannings.id')
					->whereIn('employees.researchgroup_id',$researchgroupIds)
					->where('mediumtermplannings.turn_id','=',$turn->id)
					->get();
				
				if (sizeof($plannedCoursesByMediumtermplanning) > 0) {

					foreach ($plannedCoursesByMediumtermplanning as $p) {
						array_push($planningIds, $p->id);
					}
				}
				
			}
			// 3. course, which where created by the user
			$plannedCoursesByUser = Planning::where('user_id', '=', Entrust::user()->id)->get();
			if (sizeof($plannedCoursesByUser) > 0) {

				foreach ($plannedCoursesByUser as $p) {
					array_push($planningIds, $p->id);
				}
			}
			// get all plannings
			if (sizeof($planningIds) > 0)
				$plannings = Planning::related($planningIds)->get();
		}
		
		$this->layout->content = View::make('plannings.select', compact('plannings', 'listofturns','listofcoursetypes', 'turn'));
	}

	/**
	* show status overview
	*/
	public function getStatusOverview(Turn $turn)
	{
		$listofcoursetypes = Coursetype::orderBy('short', 'ASC')->lists('short','id');
		$plannings = Planning::where('turn_id','=',$turn->id)->orderBy('course_number')->get();
		$this->layout->content = View::make('plannings.status', compact('plannings', 'turn','listofcoursetypes'));
	}

	/**
	* update planning status
	* @param Turn $turn
	*/
	public function updateStatus(Turn $turn)
	{
		if (sizeof(Input::get('selected')) > 0) {
			$plannings = Planning::whereIn('id',Input::get('selected'))->get();

			foreach ($plannings as $planning) {
				$oldResearchGroupStatus = $planning->researchgroup_status;
				$oldBoardStatus = $planning->board_status;

				/** TODO attributes shouldn't be set directly in the controller */
				$planning->board_status = Input::get('board_status');
				$planning->researchgroup_status = Input::get('researchgroup_status');
				$planning->save();

				$planninglog = new Planninglog();
				$planninglog->logUpdatedPlanningStatus($planning, $turn, $oldBoardStatus, $oldResearchGroupStatus);
			}

			Flash::success('Die Status wurden erfolgreich aktualisiert.');
			return Redirect::route('showAllPlanningsStats_path', $turn->id);
		}

		Flash::error('Es wurden keine Veranstaltungen ausgewählt.');
		return Redirect::route('showAllPlanningsStats_path', $turn->id);
	}
	
	/**
	* delete planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function destroy(Turn $turn, Planning $planning)
	{
		// delete employees from planning_employee
		$planning->employees()->detach();
		// delete room relationships from planning_room
		$planning->rooms()->detach();
		// delete exam type
		// check if the planning is for the last course of this module
		$remainingCourses = DB::table('plannings')
								->join('courses', 'courses.id', '=', 'plannings.course_id')
								->select('plannings.id')
								->where('courses.module_id', '=', $planning->course->module_id)
								->where('plannings.turn_id', '=', $turn->id)
								->get();
		if (sizeof($remainingCourses) <= 1)
			$turn->modules()->detach($planning->course->module_id);

		// delete planning
		$planninglog = new Planninglog();
		$planninglog->logDeletedPlanning($planning, $turn);

		$planning->delete();

		Flash::success('Veranstaltung erfolgreich gelöscht.');
		return Redirect::route('showTurnPlannings_path', $turn->id);
	}

	/**
	* generate lists seperated by course types
	*/
	private function getCoursetypes(Turn $turn)
	{
		// getting planed modules grouped by module
		$plannedModules = Planning::with(array('course' => function($query)
			{
				$query->groupBy('module_id');
			}))
			->where('turn_id', '=', $turn->id)
			->get();

		if (sizeof($plannedModules) > 0) {
			$plannedModulesIds = array_fetch($plannedModules->toArray(), 'id');

			$lists['bachelor'] = Module::where('degree_id','=', 1)
										->where('individual_courses','=', 0)
										->whereNotIn('id',$plannedModulesIds)
										->orderBy('name')
										->lists('name', 'id'); // TODO ids are hard coded
			$lists['master'] = Module::where('degree_id','=', 2)
									->where('individual_courses','=', 0)
									->whereNotIn('id',$plannedModulesIds)
									->orderBy('name')
									->lists('name', 'id');
		} else {
			$lists['bachelor'] = Module::where('degree_id','=', 1)
										->where('individual_courses','=', 0)
										->orderBy('name')
										->lists('name', 'id'); // TODO ids are hard coded
			$lists['master'] = Module::where('degree_id','=', 2)
									->where('individual_courses','=', 0)
									->orderBy('name')
									->lists('name', 'id');
		}
		$plannings = Planning::where('turn_id','=',$turn->id)->get();
		$courseIds = array();
		foreach ($plannings as $p) {
			array_push($courseIds, $p->course_id);
		}
		
		//lectures
		
		if (sizeof($courseIds) > 0)
			$lectures = Course::whereIn('coursetype_id',array(1, 8))
								->whereNotIn('id',$courseIds)
								->where('department_id','=',1)
								->orderBy('name', 'ASC')
								->get();
		else
			$lectures = Course::whereIn('coursetype_id',array(1, 8))
								->where('department_id','=',1)
								->orderBy('name', 'ASC')
								->get();

		if (sizeof($lectures) > 0) {
			$listOfLectures = array();
			foreach ($lectures as $l) {
				$listOfLectures = array_add($listOfLectures, $l->id, $l->name .' ('.$l->module->short.')');
			}
			$lists['lecture'] = $listOfLectures;
		}
		else
			$lists['lecture'] = array();

		$courses = Course::whereNotIn('coursetype_id',array(1, 8))
						->where('department_id','=', 1)
						->orderBy('name', 'ASC')
						->get(); // TODO remove hard coded ids
		$lists['seminar'] =  array();
		$lists['exercise'] =  array();
		$lists['integrated_seminar'] =  array();
		$lists['proseminar'] =  array();
		$lists['project'] =  array();
		$lists['practical_course'] = array();
		$lists['other'] = array();
		foreach ($courses as $course) {
			switch ($course->coursetype_id) {
				case 2:
					$lists['seminar'] = array_add($lists['seminar'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 3:
					$lists['integrated_seminar'] = array_add($lists['integrated_seminar'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 4:
					$lists['exercise'] = array_add($lists['exercise'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 5:
					$lists['proseminar'] = array_add($lists['proseminar'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 6:
					$lists['project'] = array_add($lists['project'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 7:
					$lists['practical_course'] = array_add($lists['practical_course'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 8:
					$lists['other'] = array_add($lists['other'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
				case 9:
				case 10:
				case 11:
				default:
					$lists['other'] = array_add($lists['other'], $course->id, $course->name.' ('.$course->module->short.')');
				break;
			}
		}
		return $lists;
	}
}
