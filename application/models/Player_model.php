<?php
include_once(APPPATH . 'models/Player.php');

class Player_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get($id)
	{
		$sql = 'select * from users where user_type = ? and id = ?';
		$query = $this->db->query($sql, array('player', $id));
		$record = $query->result_array()[0];
		if (!empty($record))
		{
			$player = new Player($record);
			return $player;
		}
	}

	public function all()
	{
		$sql = 'select * from users where user_type = ?';
		$query = $this->db->query($sql, array('player'));
		return $this->collection($query);
	}

	public function allNotGoalie()
	{
		$sql = 'select * from users where user_type = ? and can_play_goalie = ?';
		$query = $this->db->query($sql, array('player', 0));
		return $this->collection($query);
	}

	public function allCanPlayGoalie()
	{
		$sql = 'select * from users where user_type = ? and can_play_goalie = ?';
		$query = $this->db->query($sql, array('player', 1));
		return $this->collection($query);
	}

	public function allBestFirst()
	{
		$sql = "select * from users where user_type = ? order by ? DESC";
		$query = $this->db->query($sql, array('player', 'ranking'));
		return $this->collection($query);
	}

	protected function collection($query)
	{
		$players = array();
		foreach($query->result_array() as $record)
		{
			$player = new Player($record);;
			$players[] = $player;
		}
		return $players;
	}
}
?>