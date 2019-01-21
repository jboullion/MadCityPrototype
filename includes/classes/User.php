<?php 
/**
 * A User Object
 */
class User { 
	public $name; 
	public $email;

	/**
	 * @param string $name The name of the user
	 * @param string $email The email of the user
	 */
	function __construct($name, $email) {
		$this->name = $name;
		$this->$email = $email;
	}

	function getName(){
		return $this->$name;
	}

	function setName($name){
		$this->$name = $name;
	}

	function getEmail(){
		return $this->$email;
	}

	function setEmail($email){
		$this->$email = $email;
	}

}