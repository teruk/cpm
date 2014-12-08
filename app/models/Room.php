<?php

use LaravelBook\Ardent\Ardent;
class Room extends Ardent {
	
	protected $fillable = ['name','location', 'seats', 'room_type_id', 'beamer', 'blackboard', 'overheadprojector','accessible'];
	public static $rules = array(
			'name' => 'required|unique:rooms',
			'location' => 'required',
			'seats' => 'required|min:1',
			'room_type_id' => 'required',
	);
	public $timestamps = false;
	protected $table = 'rooms';
	
	public function roomtype()
	{
		return $this->belongsTo('RoomType');
	}
	
	public function plannings()
	{
		return $this->belongsToMany('Planning')->withPivot('weekday','start_time','end_time','created_at','updated_at');
	}
	
	/**
	* Scope for room with the same or higher number of seats
	*/
	public function scopeSeats($query, $seats)
	{
		return $query->where('seats','>=', $seats);
	}
	
	/**
	* Scope for rooms with the same room type
	*/
	public function scopeSimilar($query, Room $room)
	{
		return $query->where('id', '!=', $room->id)
// 					->where('seats', '>=', $room->seats)
					->where('room_type_id', '=', $room->room_type_id)
					->orderBy('seats', 'ASC');
	}
	
	/**
	 * Return a list of all rooms in the constallation <room name> (<room location>) - seats: <room seats>
	 * @return Ambigous <multitype:, array, mixed>
	 */
	public static function getList($seats = 0)
	{
		$rooms = static::seats($seats)->get();
		$list = array();
		foreach ($rooms as $room)
		{
			$list = array_add($list, $room->id, $room->name.' ('.$room->location.') - Plätze: '.$room->seats);
		}
		return $list;
	}
}