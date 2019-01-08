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
	$select = 
	"SELECT * FROM `parties` 
		WHERE `dm_id` = :dm_id 
			AND `party_id` = :party_id
		LIMIT 1";

	$stmt = $PDO->prepare($select);
	$result = $stmt->execute( 
		array(
			'party_id' => $_POST['party_id'],
			'dm_id' => $_POST['user_id']
		)
	);

	$party = $stmt->fetch();

}catch(PDOException $e){
	/*
	if(DEBUG){
		echo json_encode(array('error' => $e->getMessage()));
	}
	*/
}


if(empty($party)){
	echo json_encode(array('error' => 'Party could not be deleted.'));
	exit;
}


if(empty($_POST['party_password']) && ! empty($party['party_password'])){
	echo json_encode(array('error' => 'Password is required.'));
	exit;
}

if(empty($_POST['party_password'])){
	$password = '';
}else{
	$password = $_POST['party_password'];
}

try {
	$delete = 
	"DELETE FROM `parties` 
		WHERE `dm_id` = :dm_id 
			AND `party_id` = :party_id
			AND `party_password` = :party_password";

	$stmt = $PDO->prepare($delete);
	$result = $stmt->execute( 
		array(
			'party_id' => $_POST['party_id'],
			'dm_id' => $_POST['user_id'],
			'party_password' => $password,
		)
	);

	//DELETE returns no results
	echo json_encode(array('success' => 'Party deleted.'));
}catch(PDOException $e){
	/*
	if(DEBUG){
		echo json_encode(array('error' => $e->getMessage()));
	}
	*/
}




