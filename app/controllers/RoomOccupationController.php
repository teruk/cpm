<?php

class RoomOccupationController extends \BaseController {

	/**
	 * returns the schedule of a room
	 * 
	 * @return [type] [description]
	 */
	public function fetchRoom()
	{
		$input = Input::all();
		$this->setRoomOccupationSession($input['turn_id'], $input['room_id']);

		return Redirect::route('showSelectedRoomOccupation_path');
	}

	/**
	 * returns the schedule of a given turn and room
	 * @param  Turn   $turn [description]
	 * @param  Room   $room [description]
	 * @return [type]       [description]
	 */
	public function getSpecificRoom(Turn $turn, Room $room)
	{
		$this->setRoomOccupationSession($turn->id, $room->id);
		return Redirect::route('showSelectedRoomOccupation_path');
	}

	/**
	 * returns a default setting for a room
	 * @return [type] [description]
	 */
	public function getDefaultRoom(Turn $turn)
	{
		$room = Room::findOrFail(5);
		$this->setRoomOccupationSession($turn->id, $room->id);
		return Redirect::route('showSelectedRoomOccupation_path');
	}
	
	/**
	* returns the schedule of a room
	*/
	public function generateRoom()
	{
		$turn = Turn::findOrFail(Session::get('roomOccupation_turnId'));
		$room = Room::findOrFail(Session::get('roomOccupation_roomId'));
		$output = $this->generate($turn, $room);
		$listofturns = Turn::getList();
		$listofrooms = Room::getList();
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$turns = Turn::all();
		$this->layout->content = View::make('overviews.room', compact('output', 'outputTurns','room','turn','listofrooms', 'listofturns','listofroomtypes'));
	}

	/**
	 * set room occupation session variables
	 * @param [type] $turnId [description]
	 * @param [type] $roomId [description]
	 */
	private function setRoomOccupationSession($turnId, $roomId)
	{
		Session::set('roomOccupation_turnId', $turnId);
		Session::set('roomOccupation_roomId', $roomId);
	}

	/**
	* generates room schedule output for the calender
	* @return $output
	*/
	private function generate(Turn $turn, Room $room)
	{
		$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('coursetypes', 'coursetypes.id', '=','courses.coursetype_id')
					->select('plannings.group_number', 'courses.name', 'plannings.course_number', 'coursetypes.short', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time')
					->where('plannings.turn_id','=',$turn->id)
					->where('planning_room.room_id','=', $room->id)
					->get();
		$output = array();
		foreach ($events as $event)
		{
			$e = array();
			$e['title'] = $event->course_number. ' '.$event->short.' '.$event->name.' Gruppe: '.$event->group_number;
			$day = $this->getWeekdayDate($event->weekday);
				
			$e['start'] = $day.'T'.$event->start_time;
			$e['end'] = $day.'T'.$event->end_time;
			if ($event->short == "VL") {
				$e['backgroundColor'] = '#32CD32';
				$e['borderColor'] = '#228B22';
			}
			array_push($output, $e);
		}
		return $output;
	}
}