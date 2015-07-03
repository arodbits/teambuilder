<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team {

	protected $players = array(), $name, $ranking = 0;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function addPlayer($player){
		$this->ranking += $player->ranking;
		$this->players[] = $player;
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