<?php 
/**
 * A Character Object
 */
class Character { 
	// PDO Object with connection to DB
	var $PDO;

	// name
	var $name; 
	var $hero_name;
	var $power_type;
	var $total_xp;

	// vitals
	var $health;
	var $power;
	var $health_regen;
	var $power_regen;
	var $durability;
	var $resistance;

	// stats
	var $strength;
	var $dexterity;
	var $stamina;
	var $intelligence;
	var $perception;
	var $wisdom;
	var $charisma;
	var $leadership;
	var $will;

	// skills
	var $melee;
	var $stealth;
	var $dodge;
	var $fire_arms;
	var $investigate;
	var $medicine;
	var $computers;
	var $science;
	var $romance;
	var $persuasion;
	var $intimidation;
	var $alertness;

	// dynamic sets 
	var $powers;
	var $equipment;

	/**
	 * @param array $character The results of a 
	 */
	function __construct($PDO, $char_id) {

		$stmt = $PDO->prepare("SELECT * FROM characters WHERE character_id = :char_id LIMIT 1");
		$stmt->execute( array('char_id' => $char_id) );
		$data = $stmt->fetch();

		$this->name = $data['character_name'];
		$this->mutant_name = $data['character_mutant_name'];
		$this->power_type = $data['character_type'];
		$this->xp = $data['character_xp'];

		$character_data = json_decode($data['character_data'], true);

		foreach($character_data as $key => $value){
			$this->{$key} = $value;
		}

	}

	/**
	 * Lazy man's get method
	 * 
	 * @param string $prop_name The name of the property you want to get
	 */
	function getProp($prop_name){
		return $this->{$prop_name};
	}

	/**
	 * Lazy man's set method
	 * 
	 * @param string $prop_name The name of the property you want to set
	 * @param mixed $value The value of the property you want to set
	 */
	function setProp($prop_name, $value){
		$this->{$prop_name} = $value;
	}

}