<?php

use LaravelBook\Ardent\Ardent;
class Planninglog extends Ardent {
	
	protected $fillable = ['planning_id', 'action','category', 'username', 'action_type', 'turn_id'];
	public static $rules = array(
			'planning_id' => 'required',
			'action' => 'required',
			'category' => 'required',
			'username' => 'required',
			'turn_id' => 'required',
			'action_type' => 'required',
	);

	/**
	* Adds a planning log entry to the db
	* @param Planning $planning
	* @param $category integer
	* @param $action integer
	* @param $action_type integer
	*/
	public function add(Planning $planning, $category, $action, $action_type)
	{
		$this->planning_id = $planning->id;
		$this->turn_id = $planning->turn_id;
		$this->category = $category;
		$this->action_type = $action_type;
		$this->username = Entrust::user()->name;
		$this->action = $action;
		$this->save();
	}
}