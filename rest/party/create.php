<?php 
/**
 * Create a party and have them connected to a user
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_name'])) {
	echo json_encode(array('error' => 'Info Missing'));
}

try{
	$insert = "INSERT INTO `parties` ( `party_name`, `dm_id`, `user_ids`, `party_password`) 
	VALUES (:party_name, :dm_id, :user_ids, :party_password)";
	$stmt = $PDO->prepare($insert);
	$result = $stmt->execute( 
		array(
			'party_name' => $_POST['party_name'],
			'dm_id' => $_POST['user_id'],
			'user_ids' => $_POST['user_id'],
			'party_password' => $_POST['party_password'] //we are storing the party passwords as plain text for now
		)
	);
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	$_SESSION['party_ids'][] = $PDO->lastInsertId();

	echo json_encode(array('success' => 'Party created successfully', 'party_id' => $PDO->lastInsertId()));
	
	try{
		$update = "UPDATE `users` 
					SET `party_ids` = :party_ids
					WHERE `user_id` = :user_id";

		$stmt = $PDO->prepare($update);

		$result = $stmt->execute( 
			array(
				'user_id' => $_POST['user_id'],
				'party_ids' => implode(',',$_SESSION['party_ids'])
			)
		);
	}catch(PDOException $e){
		error_log($e->getMessage(), 0);
	}

	
}else{
	echo json_encode(array('error' => 'Party could not be created'));
}

