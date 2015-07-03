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
		$data = array();
		if($this->input->post('minRange') && $this->input->post('maxRange')){
			$teamService = new TeamService();
			//Generates teams dynamically with a composition form 18 to 22 players.
			$generator = $teamService->generateTeams($this->input->post('minRange'), $this->input->post('maxRange'));
			if($generator->fails()){
				$data['errors'] = $generator->errors();
			}
			$data['teams'] = $generator->getGeneratedTeams();
		}else{
			$data['errors'] = array('No range was provided. Please <a href="/tournament/create"> go back</a>');
		}
		$this->load->view('show_tournaments', $data);
	}

	public function create()
	{
		$this->load->view('create_tournaments');
	}

}
