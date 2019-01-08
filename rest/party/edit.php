<?php 
/**
 * Create a party and have them connected to a user
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['party_name']) || empty($_SESSION['email']) ) {
	echo json_encode(array('error' => 'Info Missing'));
}

// Update password if not blank
if(empty($_POST['party_password'])){
	$update = 
	"UPDATE `parties`   
		SET `party_name` = :party_name
		WHERE `dm_id` = :dm_id 
			AND `party_id` = :party_id";

	$stmt = $PDO->prepare($update);
	$result = $stmt->execute( 
		array(
			'party_name' => $_POST['party_name'],
			'party_id' => $_POST['party_id'],
			'dm_id' => $_POST['user_id'],
			
		)
	);
}else{
	$update = 
		"UPDATE `parties`   
			SET `party_name` = :party_name,
				`party_password` = :party_password
			WHERE `dm_id` = :dm_id 
				AND `party_id` = :party_id";

	$stmt = $PDO->prepare($update);
	$result = $stmt->execute( 
		array(
			'party_name' => $_POST['party_name'],
			'party_password' => $_POST['party_password'],
			'party_id' => $_POST['party_id'],
			'dm_id' => $_POST['user_id']
		)
	);
}


if(! empty($result)){
	$select = "SELECT * FROM parties WHERE party_id = :party_id"; //:party_ids
		
	$stmt = $PDO->prepare($select);
	$stmt->execute( 
		array(
			'party_id' => $_POST['party_id']
		)
	);

	$party = $stmt->fetch();
	$party['dm_email'] = $_SESSION['email'];

	echo json_encode(array('success' => 'Party edited successfully', 'party' => $party));

}else{
	echo json_encode(array('error' => 'Party could not be created'));
}

