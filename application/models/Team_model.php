<?php

class Team_model extends CI_Model {

	var $players = array();
	var $name = null;
	var $ranking = null;

	function __construct()
	{
		parent::__construct();
	}

	public function create($players, $name){
		$this->players = $players;
		$this->name = $name;
	}

	public function ranking($team){
		$team = $this->getTeam($name);
		$players = $team->players();
		$total = 0;
		foreach($players as $player){
			$total += $player->ranking;
		}
		return $total;
	}

	public function all(){
		return $this->players;
	}

	public function get($name){
		return $this->players[$name];
	}

}
?>