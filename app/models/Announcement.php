<?php

use LaravelBook\Ardent\Ardent;
class Announcement extends Ardent {
	
	protected $fillable = ['subject', 'content', 'read_more', 'user_id'];
	public static $rules = array(
			'subject' => 'required|min:3',
			'content' => 'required|min:20',
			'read_more' => 'required',
	);
	
	/**
	* Relation to user
	* @return User $user
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * update the information of the announcement
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
	 * publish a new announcement
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function publish($data)
	{
		$this->fill($data);
		$this->attributes['read_more'] = (strlen($this->content) > 120) ? substr($this->content, 0, 120) : $this->content;
		$this->attributes['user_id'] = Auth::id();
		if ($this->save())
			return true;
	}
}