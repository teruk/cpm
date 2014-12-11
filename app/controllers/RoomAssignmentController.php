<?php

class RoomAssignmentController extends \BaseController {

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
				$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
						$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
						$room->name.' ('.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.
							substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';
				$planninglog = new Planninglog();
				$planninglog->add($planning, 2, $action, 0);
				return Redirect::back()->with('message', 'Raum erfolgreich hinzugefügt.');
			}
			else 
			{
				// find alternative rooms
				$message = $this->findAlternativeRooms($room, $turn, $input);

				return Redirect::back()->with('error', 
						'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
							Config::get('constants.weekdays_short')[$input['weekday']].', '.$input['start_time'].'-'.
							$input['end_time'].' ist zu dieser Zeit schon belegt. <br>'.$message);
			}
		}
		else 
			return Redirect::back()->with('error', 'Die Endzeit liegt vor der Startzeit.');
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
				$action = "Raum aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
						$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
						$oldroom->name.' -> ('.$room->name.') ('.Config::get('constants.weekdays_short')[$input['weekday_old']].', '.
							substr($input['start_time_old'],0,5).'-'.substr($input['end_time_old'],0,5).') -> ('.Config::get('constants.weekdays_short')[$input['weekday']].', '.
							substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';

				DB::table('planning_room')
					->where('id','=', $planningroomid->id)
					->update(array('room_id' => $input['room_id'], 'weekday' => $input['weekday'], 'start_time'=> $input['start_time'], 'end_time'=> $input['end_time']));

				$planninglog = new Planninglog();
				$planninglog->add($planning, 2, $action, 1);
				return Redirect::back()->with('message', 'Raum erfolgreich aktualisiert.');
			}
			else
			{
				// find alternative
				$message = $this->findAlternativeRooms($room, $turn, $input);

				return Redirect::back()->with('error',
						'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
							Config::get('constants.weekdays_short')[$input['weekday']].', '.
							$input['start_time'].'-'.$input['end_time'].' Uhr ist zu dieser Zeit schon belegt.<br>'.$message);
			}
		}
		else
			return Redirect::back()->with('error', 'Die Endzeit liegt vor der Startzeit.');
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
			$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
					$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
					$room->name.' ('.Config::get('constants.weekdays_short')[$planning_room->weekday].', '.
						substr($planning_room->start_time,0,5).'-'.substr($planning_room->end_time,0,5).')';
			$planninglog = new Planninglog();
			$planninglog->add($planning, 2, $action, 0);
			return Redirect::back()->with('message', 'Raum erfolgreich hinzugefügt.');
		}
		else 
		{
			// find alternative
			$input = [
				'weekday' => $planning_room->weekday,
				'start_time' => $planning_room->start_time,
				'end_time' => $planning_room->end_time
				];
			$message = $this->findAlternativeRooms($room, $turn, $input);

			return Redirect::back()->with('error',
					'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.
						Config::get('constants.weekdays_short')[$input['weekday']].', '.
						$input['start_time'].'-'.$input['end_time'].' Uhr ist zu dieser Zeit schon belegt.<br>'.$message);
		}
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
		$action = "Raumzuordnung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
				$room->name.' ('.Config::get('constants.weekdays_short')[$input['weekday']].', '.
					substr($input['start_time'],0,5).'-'.substr($input['end_time'],0,5).')';
		$planninglog = new Planninglog();
		$planninglog->add($planning, 2, $action, 2);
		return Redirect::back()->with('message', 'Raum erfolgreich entfernt.');
	}


}
