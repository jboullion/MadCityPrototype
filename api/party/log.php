<?php 
/**
 * Update the party log
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_SESSION['user_id']) || empty($_POST['party_log']) ) {
	echo json_encode(array('error' => 'Info Missing'));
}

try {
	$update = 
	"UPDATE `parties` 
		SET `party_log` = :party_log
		WHERE `dm_id` = :dm_id 
			AND `party_id` = :party_id";

	$stmt = $PDO->prepare($update);
	$result = $stmt->execute( 
		array(
			'party_log' => $_POST['party_log'],
			'party_id' => $_POST['party_id'],
			'dm_id' => $_SESSION['user_id']
			
		)
	);
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	echo json_encode(array('success' => 'Party log updated'));
}else{
	echo json_encode(array('error' => 'Party could not be created'));
}