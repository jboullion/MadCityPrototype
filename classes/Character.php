<?php 
/**
 * A Character Object
 */
class Character { 
	var $name; 

	/**
	 * @param string $name The name of the character
	 */
	function __construct($name) {
		$this->name = $name;
	}

	function getName(){
		return $this->$name;
	}

	function setName($name){
		$this->$name = $name;
	}

}