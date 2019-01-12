<?php 
/**
 * DELETE party
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_id']) ) {
	echo json_encode(array('error' => 'Info Missing'));
}

try {
	$delete = 
	"DELETE FROM `party_characters` 
		WHERE `party_id` = :party_id 
			AND `user_id` = :user_id";

	$stmt = $PDO->prepare($delete);
	$result = $stmt->execute( 
		array(
			'party_id' => $_POST['party_id'],
			'user_id' => $_POST['user_id']
		)
	);

	//DELETE returns no results
	echo json_encode(array('success' => 'Player removed.'));
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}




