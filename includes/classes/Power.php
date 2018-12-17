<?php 

/**
 * A Heroes power.
 */
class Power { 
	var $type;
	var $name; 
	var $effect;
	var $damage;
	var $level;
	VAR $stat;
	var $description;

	/**
	 * @param string $name The name of the power
	 * @param string $type The type of the power
	 * @param string $description The description of the power
	 * @param int $damage The random value to determine damage
	 * @param int $act The Act the power belongs in
	 * @param int $level The level of this power. Also the number of power points it uses
	 */
	function __construct($type, $name, $effect, $description, $damage, $level, $stat) {
		$this->type = $type;
		$this->name = $name;
		$this->effect = $effect;
		$this->$description = $description;

		$this->$damage = $damage;
		$this->$level = $level;
		$this->$stat = $stat;
	}

}