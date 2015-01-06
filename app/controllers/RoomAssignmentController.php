<?php

class RoomAssignmentController extends \BaseController {

	/**
	 * show room form
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function showRooms(Turn $turn, Planning $planning)
	{
		// check if current user is allowed to access this planning
		if (!$this->checkPlanningResponsibility($turn, $planning))
		{
			Flash::error('Sie haben keine Zugriffsberechtigung für diese Planung!');
			return Redirect::route('home');
		}

		$course = Course::findOrFail($planning->course_id);

		// get list of rooms
		$rooms = Room::getList();

		// get old plannings
		$oldplannings = Planning::oldPlannings($planning, $turn)->get();
		if (sizeof($oldplannings) == 0)
			$oldplannings = array();

		// get related plannings
		$relatedplannings = Planning::relatedPlannings($planning, $course)->get();

		if (sizeof($relatedplannings) == 0)
			$relatedplannings = array();

		// get information for the conflict schedule
		$conflictcourses = $planning->getConflictCourses();
		$output = $this->getConflictCourseSchedule($conflictcourses);

		$this->layout->content = View::make('plannings.editRoom', compact('turn', 'planning', 'course', 'rooms', 'oldplannings', 'relatedplannings', 'output'));
	}

	/**
	 * Assign a room with weekday and time to a planning
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function assignRoom(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 2);

		$input = Input::all();
		$input['start_time'] = date('H:i:s', strtotime(Input::get('start_time')));
		$input['end_time'] = date('H:i:s', strtotime(Input::get('end_time')));
		$room = Room::findOrFail($input['room_id']);
		// $starttime = date('H:i:s', strtotime(Input::get('start_time')));
		// $endtime = date('H:i:s', strtotime(Input::get('end_time')));
		if ($input['start_time'] < $input['end_time'])
		{
			if (Planning::checkRoomAvailability($turn->id, $input['room_id'], $input['weekday'], $input['start_time'], $input['end_time'])->count() == 0)
			{
				$planning->rooms()->attach($room->id, array(
							'weekday'=>($input['weekday']),
							'start_time'=>$input['start_time'],
							'end_time'=>$input['end_time'],
						));

				// log
				$planninglog = new Planninglog();
				$planninglog->logAssignedPlanningRoom($planning, $turn, $room, $input);

				Flash::success('Raum erfolgreich hinzugefügt.');
				return Redirect::back();
			}
			
			// find alternative rooms
			$message = $this->findAlternativeRooms($room, $turn, $input);

			Flash::error('Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
						Config::get('constants.weekdays_short')[$input['weekday']].', '.$input['start_time'].'-'.
						$input['end_time'].' ist zu dieser Zeit schon belegt. <br>'.$message);
			return Redirect::back();
		}
		
		Flash::error('Die Endzeit liegt vor der Startzeit.');
		return Redirect::back();
	}


	/**
	 * update a room assignment
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function updateRoomAssignment(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 2);

		$input = Input::all();

		if ($input['room_id_old'] == $input['room_id']) 
		{
			$room = Room::findOrFail($input['room_id']);
			$oldroom = $room;
		}
		else
		{
			$room = Room::findOrFail($input['room_id']);
			$oldroom = Room::findOrFail($input['room_id_old']);
		}

		// TODO: move to planning
		$planningroomid = DB::table('planning_room')
							->select('id')
							->where('room_id','=',$oldroom->id)
							->where('planning_id','=', $planning->id)
							->where('weekday','=', $input['weekday_old'])
							->where('start_time', '=', $input['start_time_old'])
							->where('end_time', '=', $input['end_time_old'])
							->first();
		$input['start_time'] = date('H:i:s', strtotime($input['start_time']));
		$input['end_time'] = date('H:i:s', strtotime($input['end_time']));
		if ($input['start_time'] < $input['end_time'])
		{
			if (Planning::checkRoomAvailabilityUpdate($turn->id, $room->id, $input['weekday'], $input['start_time'], $input['end_time'], $planningroomid->id)->count() == 0)
			{
				$planninglog = new Planninglog();
				$planninglog->logUpdatedPlanningRoom($planning, $turn, $room, $input, $oldroom);

				DB::table('planning_room')
					->where('id','=', $planningroomid->id)
					->update(array('room_id' => $input['room_id'], 'weekday' => $input['weekday'], 'start_time'=> $input['start_time'], 'end_time'=> $input['end_time']));

				Flash::success('Raum erfolgreich aktualisiert.');
				return Redirect::back();
			}
			
			// find alternative
			$message = $this->findAlternativeRooms($room, $turn, $input);
			Flash::error('Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
						Config::get('constants.weekdays_short')[$input['weekday']].', '.
						$input['start_time'].'-'.$input['end_time'].' Uhr ist zu dieser Zeit schon belegt.<br>'.$message);
			return Redirect::back();
		}

		Flash::error('Die Endzeit liegt vor der Startzeit.');
		return Redirect::back();
	}

	/**
	 * copy an old room assignment from a previos turn
	 * @param  Turn     $turn     [description]
	 * @param  Planning $planning [description]
	 * @return [type]             [description]
	 */
	public function copyRoomAssignment(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 2);

		$planning_room = DB::table('planning_room')
							->select('*')
							->where('id','=',Input::get('source_planning_room_id'))
							->first();
		$room = Room::findOrFail($planning_room->room_id);
		$starttime = date('H:i:s', strtotime($planning_room->start_time));
		$endtime = date('H:i:s', strtotime($planning_room->end_time));
		// checking if the room is occupied at that day and time
		// TODO check for conflicts with other compulsory modules, when course belongs to compulsory module and is a lecture
		if (Planning::checkRoomAvailability($turn->id, $room->id, $planning_room->weekday, $starttime, $endtime)->count() == 0)
		{
			$planning->rooms()->attach($room->id, array(
						'weekday'=>($planning_room->weekday),
						'start_time'=>$planning_room->start_time,
						'end_time'=>$planning_room->end_time,
					));
			// log
			$planninglog = new Planninglog();
			$planninglog->logCopiedPlanningRoom($planning, $turn, $room, $planning_room);

			Flash::success('Raum erfolgreich hinzugefügt.');
			return Redirect::back();
		}

		// find alternative
		$input = [
			'weekday' => $planning_room->weekday,
			'start_time' => $planning_room->start_time,
			'end_time' => $planning_room->end_time
			];
		$message = $this->findAlternativeRooms($room, $turn, $input);

		Flash::error('Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
					Config::get('constants.weekdays_short')[$input['weekday']].', '.
					$input['start_time'].'-'.$input['end_time'].' Uhr ist zu dieser Zeit schon belegt.<br>'.$message);
		return Redirect::back();
	}

	/**
	 * check if similar rooms are available at the given day and time
	 * @param  Room   $room  [description]
	 * @param  Turn   $turn  [description]
	 * @param  Array  $input [description]
	 * @return [type]        [description]
	 */
	private function findAlternativeRooms(Room $room, Turn $turn, $input)
	{
		$similarrooms = Room::similar($room)->get();
		$message = "Alternative Räume: ";
		if (sizeof($similarrooms) > 0)
		{
			foreach ($similarrooms as $sr) {
				if (Planning::checkRoomAvailability($turn->id, $sr->id, $input['weekday'], $input['start_time'], $input['end_time'])->count() == 0)
					$message .= $sr->name.' (Plätze: '.$sr->seats.'); ';
			}
			return $message;
		}
		else
			return "Keine Alternativen vorhanden!";
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyRoomAssignment(Turn $turn, Planning $planning)
	{
		Session::set('plannings_edit_tabindex', 2);

		$input = Input::all();
		$planning->deleteRoomAssignment($input);		

		$room = Room::findOrFail($input['room_id']);

		// log
		$planninglog = new Planninglog();
		$planninglog->logDetachedPlanningRoom($planning, $turn, $room, $input);

		Flash::success('Raum erfolgreich entfernt.');
		return Redirect::back();
	}

	/**
	 * generate output for conflict schedule
	 * @param  [type] $plannings [description]
	 * @return [type]            [description]
	 */
	private function getConflictCourseSchedule($plannings)
	{
		$output = array();
		foreach ($plannings as $p) {
			foreach ($p->rooms as $room) {
				$e = array();
				$e['title'] = $p->course_number. ' '.$p->course->coursetype->short.' '.$p->course_title.' Gruppe: '.$p->group_number;
				$day = $this->getWeekdayDate($room->pivot->weekday);
					
				$e['start'] = $day.'T'.$room->pivot->start_time;
				$e['end'] = $day.'T'.$room->pivot->end_time;
				$e['backgroundColor'] = '#32CD32';
				$e['borderColor'] = '#228B22';
				array_push($output, $e);
			}
		}
		return $output;
	}
}
