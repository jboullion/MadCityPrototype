<?php 
/**
 * A Party Object
 */
class Party { 
	// PDO Object with connection to DB
	var $PDO;

	// The IDs of the character and user in the database
	var $party_id;
	var $dm_id;
	var $dm_email;

	var $name; 
	var $users = array();

	function __construct($PDO, $party_id, $user_id) {
		$this->PDO = $PDO;

		$this->party_id = $party_id;

		// GET the party as lon as this user is a member of the party
		try{
			$stmt = $this->PDO->prepare("SELECT * FROM parties WHERE party_id = :party_id AND user_ids LIKE :user_id LIMIT 1");
			$stmt->execute( array('party_id' => $party_id, 'user_id' => '%'.$user_id.'%') );
			$party = $stmt->fetch();

		}catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}

		$this->name = $party['party_name'];
		$this->dm_id = $party['dm_id'];
		$this->dm_email = mc_get_userinfo($party['dm_id'], 'user_email');

		if(! empty($party['user_ids'])){
			$users = explode(',',$party['user_ids']);
			foreach($users as $user_id){
				$this->users[] = mc_get_user($PDO, $user_id);
			}
		}

	}


}