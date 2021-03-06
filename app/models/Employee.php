<?php


use LaravelBook\Ardent\Ardent;
class Employee extends Ardent 
{
	
	protected $fillable = ['firstname', 'name', 'title', 'researchgroup_id', 'teaching_load', 'employed_since', 'employed_till', 'inactive'];
	public static $rules = array(
			'firstname' 	=> 'required|min:2',
			'name' 			=> 'required|min:2',
			'researchgroup_id' => 'required',
			'teaching_load' 	=> 'required|integer|min:0',
			'employed_since' 	=> 'required',
	);
	
	/**
	 * returns a list of related research groups
	 * @return [type] [description]
	 */
	public function researchgroup()
	{
		return $this->belongsTo('Researchgroup');
	}
	
	/**
	 * returns a list of related mediumterm plannings
	 * @return [type] [description]
	 */
	public function mediumtermplannings()
	{
		return $this->belongsToMany('Mediumtermplanning')->withPivot('semester_periods_per_week','annulled');
	}
	
	/**
	 * returns a list of related plannings
	 * @return [type] [description]
	 */
	public function plannings()
	{
		return $this->belongsToMany('Planning')->withPivot('semester_periods_per_week','created_at','updated_at');
	}

	/**
	 * return presentable employee
	 * @return [type] [description]
	 */
	public function present()
	{
		return $this->title.' '.$this->firstname.' '.$this->name;
	}

	/**
	* Return a list with all employees that belong to the same researchgroup and 
	* are not already assigned to a course, in the constallation <employee firstname> <employee name> (<research group short>)
	* @param array<integer>
	* @return array<employee->id, employee->firstname employee->name employee->researchgroup->short>
	*/
	public static function getAvailableEmployeesWithResearchgroup($unavailable_employee_ids)
	{
		$available_employees = array();
		if (sizeof($unavailable_employee_ids) > 0)
			$employees = static::whereNotIn('id',$unavailable_employee_ids)->orderBy('firstname','ASC')->orderBy('name','ASC')->get();
		else
			$employees = static::orderBy('firstname','ASC')->orderBy('name','ASC')->get();
		foreach ($employees as $employee) {
			$available_employees = array_add($available_employees, $employee->id, $employee->firstname.' '.$employee->name.' ('.$employee->researchgroup->short.')');
		}
		return $available_employees;
	}

	/**
	* Return a list with all employees in the constallation <employee firstname> <employee name> (<research group short>)
	* @return array<list>
	*/
	public static function getList()
	{
		$list = array();
		$listofresearchgroups = Researchgroup::lists('short','id');
		foreach (static::orderBy('firstname','ASC')->orderBy('name', 'ASC')->get() as $employee)
		{
			$list = array_add($list, $employee->id, $employee->firstname.' '.$employee->name.' ('.$listofresearchgroups[$employee->researchgroup_id].')');
		}
		return $list;
	}

	/**
	 * [saveDummyEmployee description]
	 * @param  [type]        $firstname     [description]
	 * @param  Researchgroup $researchgroup [description]
	 * @param  [type]        $title         [description]
	 * @return [type]                       [description]
	 */
	public function saveDummyEmployee($firstname, Researchgroup $researchgroup, $title)
	{
		$this->firstname = $firstname;
		$this->name = $researchgroup->short;
		$this->title = $title;
		$this->researchgroup_id = $researchgroup->id;
		$this->teaching_load = 0;
		$this->employed_since = date("Y-m-d");
		$this->employed_till = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 10 year"));
		$this->inactive = 0;
	}
}
