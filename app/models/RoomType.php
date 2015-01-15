<?php

use LaravelBook\Ardent\Ardent;
class Roomtype extends Ardent {
	
	protected $fillable = ['name', 'description'];

	public static $rules = array(
			'name' => 'required|unique:roomtypes',
	);

	public $timestamps = false;
	
	/**
	 * returns a list of related rooms
	 * @return [type] [description]
	 */
	public function rooms()
	{
		return $this->hasMany('Room');
	}
}