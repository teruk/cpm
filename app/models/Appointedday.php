<?php

use LaravelBook\Ardent\Ardent;
class Appointedday extends Ardent {
	
	protected $fillable = ['subject', 'content', 'read_more', 'date'];
	public static $rules = array(
			'subject' => 'required|:min3',
			'content' => 'required|min:10',
			'read_more' => 'required',
			'date' => 'required',
	);

	/**
	 * update the information of a appointed day
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function updateInformation($data)
	{
		$this->fill($data);
		$this->attributes['read_more'] = (strlen($this->content) > 120) ? substr($this->content, 0, 120) : $this->content;

		if ($this->updateUniques())
			return true;
	}

	/**
	 * publish a new appointed day
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function publish($data)
	{
		$this->fill($data);
		$this->attributes['read_more'] = (strlen($this->content) > 120) ? substr($this->content, 0, 120) : $this->content;

		if($this->save())
			return true;
	}
}