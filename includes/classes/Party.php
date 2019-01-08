<?php 
/**
 * A Party Object
 */
class Party { 
	// PDO Object with connection to DB
	var $PDO;

	// The IDs of the character and user in the database
	var $party_id;
	var $user_id;

	// name
	var $name; 

	function __construct($PDO, $party_id, $user_id) {
		$this->PDO = $PDO;

		$this->party_id = $party_id;
		$this->user_id = $user_id;

		//$this->name = $name;

	}


}