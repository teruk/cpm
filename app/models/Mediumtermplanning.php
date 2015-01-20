<?php

use LaravelBook\Ardent\Ardent;
class Mediumtermplanning extends Ardent 
{
	
	protected $fillable = ['module_id', 'turn_id'];
	
	public static $rules = array(
			
	);
	
	/**
	 * returns a list of related modules
	 * @return [type] [description]
	 */
	public function module() 
	{
		return $this->belongsTo('Module');
	}
	
	/**
	 * returns a list of related turns
	 * @return [type] [description]
	 */
	public function turn()
	{
		return $this->belongsTo('Turn');
	}
	
	/**
	 * returns a list of related employees
	 * @return [type] [description]
	 */
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

	/**
	 * scope that returns the medium term planning for a specific turn and specific researchgroups
	 * @param  [type] $query            [description]
	 * @param  Turn   $turn             [description]
	 * @param  [type] $researchgroupIds [description]
	 * @return [type]                   [description]
	 */
	public function scopeForSpecificResearchGroups($query, Turn $turn, $researchgroupIds)
	{
		return $query->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
					->join('employees','employees.id','=','employee_mediumtermplanning.employee_id')
					->select('mediumtermplannings.id')
					->where('mediumtermplannings.turn_id','=',$turn->id)
					->whereIn('employees.researchgroup_id',$researchgroupIds);
	}
}
