<?php 
/**
 * A piece of hero equipment
 */
class Equipment { 
	var $name; 
	var $description;
	var $damage; // the "d" value of the dice involved
	var $act;
	VAR $ammo;

	/**
	 * @param string $name The name of the power
	 * @param string $description The name of the power
	 * @param int $damage The random value to determine damage
	 * @param int $act The Act the power belongs in
	 * @param bool $burn Can this power burn power points
	 */
	function __construct($name, $description, $damage, $act, $ammo) {
		$this->name = $name;
		$this->$description = $description;
		$this->$damage = $damage; // the "d" value of the dice involved
		$this->$act = $act;
		$this->$ammo = $ammo;
		$this->notes = $notes;
	}

	function getDamage(){
		return $this->$damage;
	}

	function setDamage($damage){
		$this->$damage = $damage;
	}

	function getAmmo(){
		return $this->$ammo;
	}

	function setAmmo($ammo){
		$this->$ammo = $ammo;
	}

	function getNotes(){
		return $this->$notes;
	}

	function setNotes($notes){
		$this->$notes = $notes;
	}

}