<?php 
/**
 * Create a party and have them connected to a user
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_id']) || empty($_POST['character_id'])) {
	echo json_encode(array('error' => 'Info Missing'));
}

try{
	/*
	$insert = "INSERT INTO `party_characters` ( `party_id`, `user_id`, `character_id` ) 
	VALUES (".$_POST['party_id'].", ".$_POST['user_id'].", ".$_POST['character_id']." )";
	$result = $PDO->exec($insert);
*/

	$insert = "INSERT INTO `party_characters` ( `party_id`, `user_id`, `character_id` ) 
		VALUES ( :party_id , :user_id , :character_id )";

	$stmt = $PDO->prepare($insert);

	$result = $stmt->execute( 
		array(
			'party_id' => $_POST['party_id'],
			'user_id' => $_POST['user_id'],
			'character_id' => $_POST['character_id']
		)
	);

}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	try {
		$select = "SELECT u.user_id, u.user_name, u.user_email, c.character_id, c.character_name FROM `characters` AS c
		LEFT JOIN users AS u ON u.user_id = c.user_id 
		WHERE c.character_id LIKE :character_id 
			AND u.user_id = :user_id";
	
		$stmt = $PDO->prepare($select);

		$result = $stmt->execute( 
			array(
				'character_id' => $_POST['character_id'],
				'user_id' => $_POST['user_id'],
			)
		);
	
		$player = $stmt->fetch();

		if(! empty($player)){
			
			echo json_encode(array('success' => 'Player added.', 'player' => $player));
			exit;
		}else{
			echo json_encode(array('error' => 'No Users Found.'));
			exit;
		}
		
	}catch(PDOException $e){
		error_log($e->getMessage(), 0);
	}
}else{
	echo json_encode(array('error' => 'Player could not be added'));
}

