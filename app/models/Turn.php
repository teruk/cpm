<?php

use LaravelBook\Ardent\Ardent;
class Turn extends Ardent {
	
	protected $fillable = ['name', 'year', 'semester_start', 'semester_end'];
	public static $rules = array(
			'semester_start' => 'required',
			'semester_end' => 'required'
	);
	public $timestamps = false;
	
	public function mediumtermplannings()
	{
		return $this->hasMany('Mediumtermplanning');
	}
	
	public function plannings()
	{
		return $this->hasMany('Planning');
	}

	public function modules()
	{
		return $this->belongsToMany('Module')->withPivot('exam');
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
	* Scope to get turn afte the next turn
	*/
	public function scopeTurnAfterNext($query, Turn $current_turn)
	{
		return $query->where('year', '=', ($current_turn->year+1))->where('name', '=', $current_turn->name);
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
	* Returns a list with name and year
	* @return array
	*/
	public static function getList()
	{
		$list = array();
		$turns = DB::table('turns')
					->orderBy('year','asc')
					->orderBy('name','asc')
					->get();
		foreach ($turns as $turn) {
			$list = array_add($list, $turn->id, $turn->name.' '.$turn->year);
		}
		return $list;
	}

	/**
	* Returns a list auf available turns
	* only useful for creating new turns
	* @return array
	*/
	public static function getListofAvailableTurns()
	{
		$list = array();
		$availableturns = array();
		for ($x = 2006; $x < (date('Y')+8); ++$x)
		{
			array_push($availableturns, "SoSe ".$x);
			array_push($availableturns, "WiSe ".$x);
		}
		$list = array_diff($availableturns, static::getList());
		return $list;
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
}