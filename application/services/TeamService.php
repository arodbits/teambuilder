<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . '/models/Team.php');
class TeamService{

	protected $CI;
	public function __construct(){
		$this->CI =& get_instance();
	}

	public function generateTeams($players, $goaliePlayers, $range = array(18,19,20,21,22)){
		$target = $players->num_rows();
		$totalGoalie = $goaliePlayers->num_rows();

		$composition = array();
		$this->resolveCombinations($range, $target, 0, 0, $composition);
		if (count($composition) == 0){
			$composition = $this->adjustCombinations($range, $target);
		}
		$arrPlayers  = array();
		foreach($players->result_array() as $player){
			$arrPlayers[] = $player;
		}
		$teams = $this->getMaxEvenTeams($composition, $totalGoalie);
		return $this->balanceTeams($teams, $arrPlayers);
	}

	public function balanceTeams($teams, $players){
		shuffle($players);
		$generatedTeams = array();
		$setPlayers = array();
		foreach($teams as $team){
			$numPlayers = $team;
			for($i=0; $i<$numPlayers; $i++){
				$setPlayers[] = array_shift($players);
			}
			$generatedTeams[] = new Team($setPlayers, $this->generateName(), $this->calculateRanking($setPlayers));
			$setPlayers = array();
		}
		return $generatedTeams;
	}

	public function getMaxEvenTeams($composition, $totalGoalie){
		$bestComposition = array();
		foreach($composition as $teams){
			$cnTeams = count($teams);
			if ($cnTeams % 2 == 0){
				if (count($bestComposition) < $cnTeams){
					$bestComposition = $teams;
				}
			}
		}
		$maxNumGenerated = count($bestComposition);
		if ($totalGoalie < $maxNumGenerated){
			$bestComposition = array_slice($bestComposition, $maxNumGenerated-$totalGoalie);
			$this->getMaxEvenTeams($bestComposition, $totalGoalie);
		}
		return $bestComposition;
	}
	//When the combination doesn't fulfill the entire set of elements available
	public function adjustCombinations($arr = array(22,21,20,19,18), $target){
		$result = array();
		if ($target >=$arr[0] && $target <= $arr[count($arr)-1]){
			$result[] =  $target;
		}else if ($target > $arr[count($arr)-1] ){
			$t = floor($target / $arr[count($arr)-1]);
			for($i=0; $i<$t; $i++){
				$result[$i] = $arr[count($arr)-1];
			}
		}
		return $result;
	}

	public function resolveCombinations($arr, $target, $from, $index, &$result, $stack = array()){
		if ($target == 0 ){
			$result[] = $stack;
		}
		else if($target<0 || $from>=count($arr)){
			return;
		}else{
			$stack[$index] = $arr[$from];
			$this->resolveCombinations($arr, $target-$arr[$from], $from, $index+1, $result,  $stack);
			$this->resolveCombinations($arr, $target, $from+1, $index, $result, $stack);
		}
	}

	public function calculateRanking($players)
	{
		$totalRanking = 0;
		foreach($players as $player){
			$totalRanking +=  $player['ranking'];
		}
		return $totalRanking;
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