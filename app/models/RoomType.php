<?php

use LaravelBook\Ardent\Ardent;
class RoomType extends Ardent {
	
	protected $fillable = ['name', 'description'];
	public static $rules = array(
			'name' => 'required|unique:roomtypes',
	);
	public $timestamps = false;
	protected $table = 'roomtypes';
	
	public function rooms()
	{
		return $this->hasMany('Room');
	}
}