<?php 

/**
 * A Heroes power.
 */
class Power { 
	var $name; 
	var $description;
	var $damage; // the "d" value of the dice involved
	var $act;
	VAR $stat;

	/**
	 * @param string $name The name of the power
	 * @param string $description The name of the power
	 * @param int $damage The random value to determine damage
	 * @param int $act The Act the power belongs in
	 * @param bool $burn Can this power burn power points
	 */
	function __construct($name, $description, $damage, $act, $stat) {
		$this->name = $name;
		$this->$description = $description;
		$this->$damage = $damage; // the "d" value of the dice involved
		$this->$act = $act;
		$this->$stat = $stat;
	}

	/**
	 * Roll this power
	 * 
	 * @param int $attack 
	 */
	function roll($attack = 0, $stat = 0, $items = 0){
		return rand(1,20) + $stat + $items;
	}

}