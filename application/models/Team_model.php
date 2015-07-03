<?php
// Mocking the team model
class Team_model extends CI_Model {

	//Acting as the database holding.
	var $teams = array();

	function __construct()
	{
		parent::__construct();
	}

	public function create(Team $team){
		$this->teams[] = $team;
	}

	public function clean(){
		$this->teams = array();
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
		return $this->teams;
	}

	public function get($name){
		return $this->teams[$name];
	}

}
?>