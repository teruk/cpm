<?php

use LaravelBook\Ardent\Ardent;
class Mediumtermplanning extends Ardent {
	
	protected $fillable = ['module_id', 'turn_id'];
	
	public static $rules = array(
			
	);
	
	public function module() 
	{
		return $this->belongsTo('Module');
	}
	
	public function turn()
	{
		return $this->belongsTo('Turn');
	}
	
	public function employees()
	{
		return $this->belongsToMany('Employee')->withPivot('semester_periods_per_week','annulled');
	}
	
	public function scopeGroupTurn($query)
	{
		return $query->groupBy('turn_id');
	}
	
	/**
	* Selects all medium term plannings from a specific turn
	* @param $query
	* @param Turn $turn
	*/
	public function scopeSpecificTurn($query, Turn $turn)
	{
		return $query->where('turn_id','=',$turn->id);
	}

	/**
	* detaches all the employees that are assigned to the medium term planning
	*/
	public function detachEmployees()
	{
		foreach ( $this->employees as $employee)
		{
			$this->employees()->detach($employee->id);
		}
	}

	/**
	 * Return all employee ids from employees that are assigned to this medium term planning
	 * @return array<integer>
	 */
	public function getEmployeeIds()
	{
		$ids = array();
		foreach ($this->employees as $employee) {
			array_push($ids, $employee->id);
		}
		return $ids;
	}
}