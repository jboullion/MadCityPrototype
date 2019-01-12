<?php 
/**
 * Create a party and have them connected to a user
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_name'])) {
	echo json_encode(array('error' => 'Info Missing'));
	exit;
}

if(empty($_POST['party_password'])){
	$password = '';
}else{
	$password = $_POST['party_password'];
}

try{
	$insert = "INSERT INTO `parties` ( `party_name`, `dm_id`, `party_password`) 
	VALUES (:party_name, :dm_id, :party_password)";
	$stmt = $PDO->prepare($insert);
	$result = $stmt->execute( 
		array(
			'party_name' => $_POST['party_name'],
			'dm_id' => $_POST['user_id'],
			'party_password' => $password //we are storing the party passwords as plain text for now
		)
	);
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	try{
		$insert = "INSERT INTO `party_characters` ( `party_id`, `user_id` ) 
		VALUES ( :party_id , :user_id  )";

		$stmt = $PDO->prepare($insert);

		$result = $stmt->execute( 
			array(
				'party_id' => $PDO->lastInsertId(),
				'user_id' => $_POST['user_id']
			)
		);

		if($result){
			echo json_encode(array('success' => 'Party created successfully', 'party_id' => $PDO->lastInsertId()));
		}else{
			echo json_encode(array('error' => 'Party could not be setup'));
		}
	}catch(PDOException $e){
		error_log($e->getMessage(), 0);
	}

	

}else{
	echo json_encode(array('error' => 'Party could not be created'));
}

