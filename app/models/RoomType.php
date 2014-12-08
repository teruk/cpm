<?php

use LaravelBook\Ardent\Ardent;
class RoomType extends Ardent {
	
	protected $fillable = ['name', 'description'];
	public static $rules = array(
			'name' => 'required|unique:room_types',
	);
	public $timestamps = false;
	
	public function rooms()
	{
		return $this->hasMany('Room');
	}
}