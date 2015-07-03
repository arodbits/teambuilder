<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . 'models/Team.php');

class TeamService{

	protected $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}

	public function generateTeams($players, $goaliePlayers, $range = array(18,19,20,21,22)){
		$this->CI->load->model('Team_model', 'team');
		$this->CI->load->model('Player_model', 'player');

		//Get from repository
		$teams = $this->CI->team->all();
		$players = $this->CI->player->all();
		$goaliePlayers = $this->CI->player->allCanPlayGoalie();

		//Number of players and Players that can play goalie
		$nPlayers = count($players);
		$nGoalies = count($goaliePlayers);

		//Number of teams possible
		$nTeams = $this->numTeams($nPlayers, $nGoalies);

		$result = $this->balance($players, $nTeams);
		return $result;
	}
	public function balance($players, $nTeams, $maxComposition = 22){
		//Initializing the teams;
		shuffle($players);
		$teams = array();
		for($i=0; $i<$nTeams; $i++){
			$player = array_shift($players);
			$name = $this->generateName();
			$team = new Team($name);
			$teams[] = $team;
		}
		//Balancing
		$nPlayers = count($players);
		while(count($players) > 0 && (count($teams) * $maxComposition) <= ($nTeams * $maxComposition)){
			usort($teams,function($a,$b) {return ($a->ranking) - ($b->ranking);});
			$player = array_shift($players);
			$teams[0]->addPlayer($player);
		}
		return $teams;
	}
	//Make sure to return even teams.
	public function numTeams($nPlayers, $nGoalies, $minRange = 18)
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

	function generateName($length = 5)
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