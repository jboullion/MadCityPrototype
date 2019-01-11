<?php 
/**
 * Create a party and have them connected to a user
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_id'])) {
	echo json_encode(array('error' => 'Info Missing'));
}

try{
	$insert = "INSERT INTO `party_characters` ( `party_id`, `user_id` ) 
	VALUES (:party_id, :user_id)";
	$stmt = $PDO->prepare($insert);
	$result = $stmt->execute( 
		array(
			'party_id' => $_POST['party_id'],
			'user_id' => $_POST['user_id']
		)
	);
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	try {
		$select = "SELECT user_id, user_name, user_email FROM `users`
					WHERE user_id = :user_id LIMIT 1";
	
		$stmt = $PDO->prepare($select);
		$result = $stmt->execute( 
			array(
				'user_id' => $_POST['user_id'],
			)
		);
	
		$user = $stmt->fetch();

		if(! empty($user)){
			
			echo json_encode(array('success' => 'Player added.', 'user' => $user));
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

