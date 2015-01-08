<?php

class RoomSearchController extends \BaseController {

	/**
	 * [showRoomSearch description]
	 * @return [type] [description]
	 */
	public function showRoomSearch()
	{
		if(Session::get('result') == "")
			$searchresults = array();
		else
			$searchresults = Session::get('result');

		if(Session::get('turn') == "")
			$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		else
			$turn = Turn::find(Session::get('turn'));

		$turns = Turn::getList();
		$roomtypes = RoomType::lists('name','id');
		$this->layout->content = View::make('rooms.search', compact('searchresults','turns','roomtypes','turn'));
	}

	/**
	 * [roomSearch description]
	 * @return [type] [description]
	 */
	public function search()
	{
		$starttime = date('H:i:s', strtotime(Input::get('start_time')));
		$endtime = date('H:i:s', strtotime(Input::get('end_time')));
		$maxseats = 10000;
		if (Input::get('max_seats') >= Input::get('min_seats') || Input::get('max_seats') == "")
		{
			if (Input::get('max_seats') != "")
			{
				$maxseats = Input::get('max_seats');
			}
			$results = DB::table('planning_room')
						->join('plannings', 'planning_room.planning_id','=','plannings.id')
						->join('rooms','rooms.id','=','planning_room.room_id')
						->select('rooms.id')
						->where('plannings.turn_id', '=', Input::get('turn_id')) // Import to select ohne results from the same turn
						->where('planning_room.weekday','=' ,Input::get('weekday'))
						->where('rooms.roomtype_id','=', Input::get('room_type_id'))
						->where(function($query) use ($starttime, $endtime)
						{
							$query->where(function($q1) use ($starttime){
								$q1->where('planning_room.start_time', '<', $starttime)
								->where('planning_room.end_time', '>', $starttime);
							})
							->orWhere(function ($q2) use ($endtime){
								$q2->where('planning_room.start_time', '<', $endtime)
								->where('planning_room.end_time', '>', $endtime);
							})
							->orWhere(function ($q3) use ($starttime, $endtime){
								$q3->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q4) use ($starttime, $endtime){
								$q4->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							})
							->orWhere(function ($q5) use ($starttime, $endtime){
								$q5->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q6) use ($starttime, $endtime){
								$q6->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							});
						})
						->orderBy('seats','ASC')
						->get();
			$room_ids = array();
			foreach ($results as $res) {
				array_push($room_ids, $res->id);
			}
			$result = array();
			if (sizeof($room_ids) > 0)
			{
				$result = Room::where('roomtype_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->whereNotIn('id',$room_ids)
								->get();
			}
			else
			{
				$result = Room::where('roomtype_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->get();
			}
			if (sizeof($result) > 0)
				return Redirect::back()->withInput()->with('result', $result)->with('turn', Input::get('turn_id'));
			else
			{
				Flash::error('Keine freien Räume gefunden!');
				return Redirect::back()->withInput();
			}
		}

		Flash::error('Fehlerhafte Eingabe! Die maximale Platzanzahl ist kleiner als die minimale Platzanzahl!');
		return Redirect::back()->withInput();
	}

}
