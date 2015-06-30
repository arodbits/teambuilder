<?php

class Player_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all()
	{
		$sql = 'select * from users where user_type = ?';
		$query = $this->db->query($sql, array('player'));
		$users = array();
		foreach($query->result() as $key => $user){
			$users[] = $user;
		}
		return $users;
	}

}
?>