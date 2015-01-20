<?php

use LaravelBook\Ardent\Ardent;
class Turn extends Ardent 
{
	
	protected $fillable = ['name', 'year', 'semester_start', 'semester_end'];
	public static $rules = array(
			'semester_start' => 'required',
			'semester_end' => 'required'
	);
	public $timestamps = false;
	
	/**
	 * returns a list of related medium term plannings
	 * @return [type] [description]
	 */
	public function mediumtermplannings()
	{
		return $this->hasMany('Mediumtermplanning');
	}
	
	/**
	 * returns a list of related plannings
	 * @return [type] [description]
	 */
	public function plannings()
	{
		return $this->hasMany('Planning');
	}

	/**
	 * returns a list of related modules
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->belongsToMany('Module')->withPivot('exam');
	}

	/**
	 * returns a list of related specialist regulations
	 * @return [type] [description]
	 */
	public function specialistregulations()
	{
		return $this->hasMany('Specialistregulation');
	}

	/**
	 * return a presentable form of the turn
	 * @return [type] [description]
	 */
	public function present()
	{
		return $this->name.' '.$this->year;
	}
	
	public function scopeOrderYearName($query)
	{
		return $query->orderBy('year','ASC')->orderBy('name','ASC');
	}
	
	/**
	 * Returns a specific Turn
	 */
	public function scopeNextYear($query, $year, $name)
	{
		return $query->where('year', '=', $year)->where('name','=', $name);
	}

	/** 
	* Scope to get the next turn
	*/
	public function scopeNextTurn($query, Turn $current_turn)
	{
		if ($current_turn->name == "SoSe")
		{
			$year = $current_turn->year;
			$name = "WiSe";
		}
		else
		{
			$year = $current_turn->year+1;
			$name = "SoSe";
		}
		return $query->where('year', '=', $year)->where('name','=', $name);
	}

	/**
	* Scope to get the turns before a specific turn
	*/
	public function scopeBeforeTurns($query, Turn $current_turn)
	{
		if ($current_turn->name == "SoSe")
		{
			return $query->where('year', '<', $current_turn->year)->orderBy('year','DESC')->orderBy('name','DESC');
		}
		else
		{
			return $query->where('year', '<=', $current_turn->year)->where('id','!=', $current_turn->id)->orderBy('year','DESC')->orderBy('name','DESC');
		}
	}

	/**
	 * return a list of available turns by a given array of taken turns
	 * 
	 * @param  [type] $idsOfNotAvailableTurns [description]
	 * @return [type]                         [description]
	 */
	public static function getAvailableTurns($idsOfNotAvailableTurns = [])
	{
		if (sizeof($idsOfNotAvailableTurns) > 0)
			$rawAvailableTurns = Turn::whereNotIn('id', $idsOfNotAvailableTurns)->orderBy('year','asc')->orderBy('name', 'asc')->get();
		else
			$rawAvailableTurns = Turn::orderBy('year','asc')->orderBy('name', 'asc')->get();
		
		$availableTurns = [];

		foreach ($rawAvailableTurns as $turn) {
			$availableTurns = array_add($availableTurns, $turn->id, $turn->present());
		}

		return $availableTurns;
	}

	/**
	* Returns a list auf available turns
	* only useful for creating new turns
	* TODO: RENAME THE FUNCTION
	* @return array
	*/
	public static function getListofAvailableTurns()
	{
		$availableTurns = array();
		for ($x = 2006; $x < (date('Y')+8); ++$x)
		{
			array_push($availableTurns, "SoSe ".$x);
			array_push($availableTurns, "WiSe ".$x);
		}
		$availableTurns = array_diff($availableTurns, static::getAvailableTurns());
		return $availableTurns;
	}

	/**
	* Return the predecessor turn
	* @return $turn or -1, if there is no predecessor turn
	*/
	public function getPredecessor()
	{
		$predecessor = static::where('name', '=', $this->name)
						->where('year', '=', ($this->year-1))
						->first();
		// check if a predecessor was found
		if (sizeof($predecessor) == 0)
			return -1;

		return $predecessor;
	}

	/**
	* Save the exam of the module for this turn
	* checks if the exam is already saved
	* @param Module $module
	*/
	public function saveExam(Module $module)
	{
		$exists = false;
		foreach($this->modules as $m)
		{
			if ($m->id == $module->id)
				$exists = true;
		}
		if (!$exists)
			$this->modules()->attach($module, array('exam' => $module->exam_type, 'created_at' => new Datetime, 'updated_at' => new Datetime));
	}

	/**
	* check if the data is ok
	*/
	public function checkLogic()
	{
		$passed = array();
		/*
		 * before the turn can be saved, there need to be some logical checks:
		* 1. the selected semester_start should be in the same year as the selected year
		* 2. the selected date for semester_end should be after the semester_start
		* 3. the difference between the year of the the semester_start and semester_end should be at max 1
		*/
		$logicalcheckpassed = true;
		$message = "";
		$encDateTime1 = $this->semester_start;
		$date1 = DateTime::createFromFormat('Y-m-d', trim($encDateTime1));
		$year1 = $date1->format('Y');
		$month1 = $date1->format('m');
		$day1 = $date1->format('d');
		$encDateTime2 = $this->semester_end;
		$date2 = DateTime::createFromFormat('Y-m-d', trim($encDateTime2));
		$year2 = $date2->format('Y');
		$month2 = $date2->format('m');
		$day2 = $date2->format('d');
		// check 1
		if ($year1 != $this->year)
		{
			$logicalcheckpassed = false;
			$message = "Fehler: Der Semesterstart liegt nicht im ausgewählten Jahr (".$this->year.").";
		}
		// check 2
		if ($year1 > $year2)
		{
			$logicalcheckpassed = false;
			$message = $message."Fehler: Das Semesterende liegt vor dem Semesterstart. ";
		}
		elseif ($year1 == $year2)
		{
			if ($month1 > $month2)
			{
				$logicalcheckpassed = false;
				$message = $message."Fehler: Das Semesterende liegt vor dem Semesterstart. ";
			}
			elseif ($month1 == $month2)
			{
				if ($day1 > $day2)
				{
					$logicalcheckpassed = false;
					$message = $message."Fehler: Das Semesterende liegt vor dem Semesterstart. ";
				}
			}
		}
		
		// check 3
		if (($year2-$year1) > 1) // not necessary to check for negativ numbers, because it's implicit in check 2
		{
			$logicalcheckpassed = false;
			$message = $message."Fehler: Der Semesterstart und das Semesterende liegen zuweit auseinander";
		}
		$passed['successful'] = $logicalcheckpassed;
		$passed['message'] = $message;
		return $passed;
	}

	/**
	 * get the users planning for this turn
	 *
	 * TODO: a better place for this method would be a (planning) repository
	 * @return [type] [description]
	 */
	public function getMyPlannings()
	{
		// get the planned courses for the current turn
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$myPlannings = Planning::turnCourses($this)->get();
		else
		{
			$rg_ids = $this->getIds(Entrust::user()->researchgroups);
			// plannings with employees of the specific research groups
			$myPlannings = DB::table('plannings')
				->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
				->join('employees', 'employees.id','=','employee_planning.employee_id')
				->join('researchgroups', 'researchgroups.id', '=', 'employees.researchgroup_id')
				->select('plannings.id')
				->whereIn('researchgroups.id',$rg_ids)
				->where('plannings.turn_id','=', $this->id)
				->groupBy('plannings.id')
				->get();
			$planning_ids = array();
			if (sizeof($myPlannings) > 0)
			{
				foreach ($myPlannings as $p) {
					array_push($planning_ids, $p->id);
				}
			}
			else 
				$myPlannings = array();

			// plannings which were created the current user
			$myPlannings_user = Planning::where('user_id','=',Entrust::user()->id)
								->where('turn_id','=',$this->id)
								->groupBy('id')
								->get();
			if (sizeof($myPlannings_user) > 0)
			{
				foreach ($myPlannings_user as $p) {
					if (!in_array($p->id, $planning_ids))
						array_push($planning_ids, $p->id);
				}
			}
			// plannings by medium-term planning
			// the target is to find plannings, where two pr more research groups are involved
			// if one of the research groups creates the planning, the other ones have to see it
			$myPlannings_mediumtermplanning = DB::table('plannings')
													->join('courses','courses.id','=','plannings.course_id')
													->join('mediumtermplannings','mediumtermplannings.module_id','=','courses.module_id')
													->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
													->join('employees','employee_mediumtermplanning.employee_id','=','employees.id')
													->select('plannings.id')
													->where('plannings.turn_id','=',$this->id)
													->where('user_id','!=', Entrust::user()->id)
													->whereIn('employees.researchgroup_id',$rg_ids)
													->groupBy('plannings.id')
													->get();
			if (sizeof($myPlannings_mediumtermplanning) > 0)
			{
				foreach ($myPlannings_mediumtermplanning as $p) {
					if (!in_array($p->id, $planning_ids))
						array_push($planning_ids, $p->id);
				}
			}

			if (sizeof($planning_ids) > 0)
				$myPlannings = Planning::related($planning_ids)->get();
		}
		return $myPlannings;
	}
}
