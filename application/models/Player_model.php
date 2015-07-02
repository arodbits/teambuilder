<?php

class Player_model extends CI_Model {

	var $user_type = '';
	var $first_name = '';
	var $last_name = '';
	var $ranking = '';
	var $can_play_goalie = '';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPlayer($id){
		$sql = 'select * from users where user_type = ? and id = ?';
		$query = $this->db->query($sql, array('player', $id));
		return $query->result();
	}

	public function all()
	{
		$sql = 'select * from users where user_type = ?';
		$query = $this->db->query($sql, array('player'));
		return $query;
	}

	public function getAllCanPlayGoalie(){
		$sql = 'select * from users where user_type = ? and can_play_goalie = ?';
		$query = $this->db->query($sql, array('player', 1));
		return $query;
	}

	public function getBestFirst(){
		$sql = "select * from users where user_type = ? order by ? DESC";
		$query = $this->db->query($sql, array('player', 'ranking'));
		return $query;
	}

}
?>