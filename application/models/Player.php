<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Player {

	protected $first_name, $last_name, $user_type, $ranking, $can_play_goalie;

	public function __construct($player = array())
	{
		$this->first_name = $player['first_name'];
		$this->last_name = $player['last_name'];
		$this->user_type = $player['user_type'];
		$this->ranking = $player['ranking'];
		$this->can_play_goalie = $player['can_play_goalie'];
	}

	public function __get($propertyName)
	{
		if (property_exists($this, $propertyName))
			return $this->$propertyName;
	}

	public function __set($name, $value)
	{
		if (property_exists($this, $name)){
			$this->name = $value;
		}
	}


}