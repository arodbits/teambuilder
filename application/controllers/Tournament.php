<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tournament extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Player_model','player');
		$teams = array();
		$players = $this->player->all();
		$d = count($players);
		//Calculate the teams and hold them in the $composition variable
		$composition = array();
		$this->calculateTeams($d, $composition);
		var_export($composition);
		die();
		$this->load->view('show_tournaments', $data);
	}
	//Recursively calculate the number of teams and the possible number of players per team.
	public function calculateTeams($d, &$composition){
		if ($d < 18)
			return;
		if ($d >= 18 && $d <=22){
			$composition[] = array('teams'=>1, 'players'=>$d);
		}
		else if ($d > 22){
			$r = ($d % 22);
			$t = floor($d/22);
			$p = 22;
			$composition[] = array('teams'=>$t, 'players'=>$p);
			if ($r > 0){
				return $this->calculateTeams($r, $composition);
			}
		}
	}

}
