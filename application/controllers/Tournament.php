<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH . 'services/TeamService.php');

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
		$teamService = new TeamService();
		//Generates teams dynamically with a composition form 18 to 22 players.
		$teams = $teamService->generateTeams(18, 22);
		$data = array();
		if(isset($teams)){
			$data['teams'] = $teams;
		}
		$this->load->view('show_tournaments', $data);
	}

}
