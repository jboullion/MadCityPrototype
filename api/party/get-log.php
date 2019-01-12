<?php 
/**
 * DELETE party
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

if(empty($_GET) || empty($_GET['party_id']) || empty($_SESSION['user_id']) ) {
	echo json_encode(array('error' => 'Info Missing'));
	exit;
}

try {
	$select = "SELECT party_log FROM `parties` 
				WHERE party_id LIKE :party_id";

	$stmt = $PDO->prepare($select);
	$result = $stmt->execute( 
		array(
			'party_id' => $_GET['party_id'],
		)
	);

	$log = $stmt->fetch();

	if(! empty($log)){
		echo $log['party_log'];
	}else{
		//echo json_encode(array('error' => 'No Users Found.'));
	}
	
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}




