<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'models/Team.php');

class TeamService
{
	protected $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}

	public function generateTeams($minComposition, $maxComposition){
		//No negative values or range not expected, return.
		if(($minComposition <= 0 || $maxComposition <=0) || $maxComposition < $minComposition)
			return;

		$this->CI->load->model('Player_model', 'player');

		//Get players from repository
		$players = $this->CI->player->allNotGoalie();
		$goaliePlayers = $this->CI->player->allCanPlayGoalie();

		//Get number of players
		$nPlayers = count($players);
		$nGoalies = count($goaliePlayers);

		//Resolve the number of teams to be created.
		$nTeams = $this->numTeams($nPlayers, $nGoalies, $minComposition);
		//If two or more teams are resolved.
		if(isset($nTeams)){
			//Distribute the players within teams while making sure the distribution is fair.
			$distributedTeams = $this->distributePlayers($players, $goaliePlayers, $nTeams, $maxComposition);
			return $distributedTeams;
		}
	}
	public function distributePlayers($players, $goaliePlayers, $nTeams, $maxComposition){
		//Initializing the teams
		$teams = array();
		//Randomly choose goalie players.
		shuffle($goaliePlayers);
		for($i=0; $i<$nTeams; $i++){
			$player = array_shift($goaliePlayers);
			$name = $this->generateName();
			$team = new Team($name);
			$team->addPlayer($player);
			$teams[] = $team;
		}
		//Insert any remaining goalie player into the players' array
		foreach($goaliePlayers as $player){
			$players[] = $player;
		}
		//Distribution
		//Get the number of players still available.
		$nPlayers = count($players);
		//Array containing the final computed distribution.
		$completedTeams = array();
		//Shuffle the remaining players.
		shuffle($players);

		while(count($players) > 0 && count($teams) > 0 && ($this->getTotalPlayers($teams) <= ($nTeams * $maxComposition))){
			//While the condition is true, check which team is the one with the lowest ranking number. Add the new player
			//into that team.
			usort($teams,function($a,$b) {return ($a->ranking) - ($b->ranking);});
			//If the team has reached the maximum amount of players allowed by $maxComposition, then remove that team from the
			//teams composition and add it to the $completeTeams array.
			if($teams[0]->getNumberOfPlayers() == $maxComposition){
				$completedTeams[] = array_shift($teams);
			}
			else{
			 	$player = array_shift($players);
			 	$teams[0]->addPlayer($player);
			}
		}
		//Include those teams with the total number of players within the minComposition and maxComposition number of players.
		foreach($teams as $team)
			$completedTeams[] = $team;
		//This is the final returned composition.
		return $completedTeams;

	}
	//Returns the total number of players already distributed.
	public function getTotalPlayers($teams)
	{
		$total = 0;
		foreach($teams as $team){
			$total += $team->getNumberOfPlayers();
		}
		return $total;
	}

	//Computes the number of players that will be used in the distribution process.
	public function numTeams($nPlayers, $nGoalies, $minRange)
	{
		if (($nGoalies % 2 == 0) && $nGoalies > 1 && $nPlayers >= $minRange * 2)
		{
			$maxTeams = floor($nPlayers / $minRange);
			$nGoalies >= $maxTeams ? $maxTeams : $maxTeams = $nGoalies;
			return $maxTeams;
		}else{
			return $this->numTeams($nPlayers, $nGoalies-1);
		}
	}
	//Generates randomly names.
	public function generateName($length = 5)
	{
		$ch = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$chLen = strlen($ch);
		$name = '';
		for ($i = 0; $i < $length; $i++) {
			$name .= $ch[rand(0, $chLen - 1)];
		}
		return $name;
	}

}