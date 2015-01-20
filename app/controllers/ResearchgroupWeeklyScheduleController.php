<?php

class ResearchgroupWeeklyScheduleController extends \BaseController 
{

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);

		$output = $this->getSchedule($turn->getMyPlannings());

		$this->layout->content = View::make('plannings.schedule', compact('output', 'turnNav'));
	}

	/**
	 * generate output for the conflict courses
	 * @param  [type] $plannings [description]
	 * @return [type]            [description]
	 */
	private function getSchedule($plannings)
	{
		$output = array();
		foreach ($plannings as $p) {
			foreach ($p->rooms as $room) {
				$e = array();
				$e['title'] = $p->course_number. ' '.$p->course->coursetype->short.' '.$p->course->module->short.' ';
				foreach ($p->employees as $employee) {
					$e['title'] .= $employee->name.'; ';
				}
				$day = $this->getWeekdayDate($room->pivot->weekday);
					
				$e['start'] = $day.'T'.$room->pivot->start_time;
				$e['end'] = $day.'T'.$room->pivot->end_time;
				// $e['backgroundColor'] = '#32CD32';
				// $e['borderColor'] = '#228B22';
				array_push($output, $e);
			}
		}
		return $output;
	}
}
