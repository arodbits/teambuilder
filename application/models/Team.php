<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team
{
	protected $players = array(), $name, $ranking = 0, $numberPlayers = 0;

	public function __construct($name)
	{
		$this->name = $name;
	}
	//Add a new player and update the $numberPlayers which holds the current total number of players already stored on the team.
	public function addPlayer($player){
		$this->ranking += $player->ranking;
		$this->numberPlayers++;
		$this->players[] = $player;
	}
	//By convenience we keep track of the number of players stored when a new player is added.
	//This way we can easyly return the number of players already computed,
	//instead of using count($players) every time we need to know this information..
	public function getNumberOfPlayers(){
		return $this->numberPlayers;
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