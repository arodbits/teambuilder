<?php

class Player_model extends CI_Model {

	protected $userType = 'player';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all()
	{
		$sql = 'select * from users where user_type = ?';
		$query = $this->db->query($sql, array($this->userType));
		return $query;
	}

	public function getAllCanPlayGoalie(){
		$sql = 'select * from users where user_type = ? and can_play_goalie = ?';
		$query = $this->db->query($sql, array($this->userType, 1));
		return $query;
	}

	public function getBestFirst(){
		$sql = "select * from users where user_type = ? order by ? DESC";
		$query = $this->db->query($sql, array($this->userType, 'ranking'));
		return $query;
	}

	public function toArray($query){
		$result = array();
		foreach($query->result() as $key => $value){
			$result[] = $value;
		}
		return $result;
	}

}
?>