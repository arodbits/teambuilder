<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TeamService{

	protected $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}

	public function generateTeams($players, $goaliePlayers, $range = array(18,19,20,21,22)){
		$this->CI->load->model('Team_model', 'team');
		$this->CI->load->model('Player_model', 'player');
		$teams = $this->CI->team->all();
		$players = $this->CI->player->all();
		var_export($this->numTeams($players->num_rows(), 6));
		die();
	}
	//Make sure to return even teams.
	public function numTeams($nPlayers, $nGoalies)
	{
		$maxTeams = floor($nPlayers / 18); //fixed?
		if (($nGoalies % 2 == 0) && $nGoalies > 1 && $nPlayers >= 18) // Fixed?
		{
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