<?php 
/**
 * DELETE party
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['character_id']) ) {
	echo json_encode(array('error' => 'Info Missing'));
}


try {
	$update = 
	"UPDATE `characters` 
		SET `active` = 0 
		WHERE `character_id` = :character_id
			AND `user_id` = :user_id";

	$stmt = $PDO->prepare($update);

	$result = $stmt->execute( 
		array(
			'character_id' => $_POST['character_id'],
			'user_id' => $_POST['user_id'],
		)
	);

	//DELETE returns no results
	if($result){
		echo json_encode(array('success' => 'Character deleted.'));
	}else{
		echo json_encode(array('error' => 'Unable to delete Character.'));
	}
	
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
	/*
	if(DEBUG){
		echo json_encode(array('error' => $e->getMessage()));
	}
	*/
}




