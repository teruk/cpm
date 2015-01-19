<?php

use Eloquent;

class Specialistregulation extends Eloquent 
{
	protected $fillable = ['degreecourse_id', 'turn_id', 'description', 'active'];

	public $rules = [
		'degreecourse_id' => 'required',
		'turn_id' => 'required',
		'active' => 'min:0|max:1'
		];

	/**
	 * returns the related degree course
	 * @return [type] [description]
	 */
	public function degreecourse()
	{
		return $this->belongsTo('Degreecourse');
	}

	/**
	 * returns the related turn
	 * @return [type] [description]
	 */
	public function turn()
	{
		return $this->belongsTo('Turn');
	}

	/**
	 * return a list of related modules
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->belongsToMany('Module')->withPivot('section', 'semester')->orderBy('semester','asc')->orderBy('section','asc');
	}

	/**
	 * return a presentable specialist regulation
	 * @return [type] [description]
	 */
	public function present()
	{
		return $this->degreecourse->present().' (ab '.$this->turn->present().')';
	}

	/**
	 * return a short presentable specialist regulation
	 * @return [type] [description]
	 */
	public function presentShort()
	{
		return $this->degreecourse->short.' (ab '.$this->turn->present().')';
	}

	/**
	 * returns an array with active specialist regulations
	 * @return [type] [description]
	 */
	public static function getList()
	{
		$specialistregulations = Specialistregulation::where('active', '=', 1)->orderBy('degreecourse_id')->orderBy('turn_id', 'asc')->get();
		$activeSpecialistregulations = [];
		foreach ($specialistregulations as $specialistregulation) {
			$activeSpecialistregulations = array_add($activeSpecialistregulations, $specialistregulation->id, $specialistregulation->present());
		}

		return $activeSpecialistregulations;
	}

	/**
	 * sets the specialist regualations active
	 */
	public function setSpecialistregulationActive()
	{
		$this->attributes['active'] = 1;
	}

	/**
	 * set the specialist regualtions inactive
	 */
	public function setSpecialistregulationInactive()
	{
		$this->attributes['active'] = 0;
	}

	/**
	 * sets the attributes for the module
	 * @param [type] $input [description]
	 */
	public function setAttributes($input)
	{
		$this->attributes['degreecourse_id'] = $input['degreecourseId'];
		$this->attributes['turn_id'] = $input['turnId'];
		$this->attributes['description'] = $input['description'];
	}
}