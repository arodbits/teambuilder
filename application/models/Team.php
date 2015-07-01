<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team {

	protected $players = array(), $name, $ranking;

	public function __construct($players = array(), $name, $ranking){
		$this->players = $players;
		$this->name = $name;
		$this->ranking = $ranking;
	}

	public function __get($propertyName){
		if (property_exists($this, $propertyName))
			return $this->$propertyName;
	}

	public function __set($name, $value){
		if (property_exists($this, $name)){
			$this->name = $value;
		}
	}

}
