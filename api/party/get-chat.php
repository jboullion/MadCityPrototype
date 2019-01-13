<?php 
/**
 * DELETE party
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

if(empty($_GET) || empty($_GET['party_id']) || empty($_GET['send_id']) || ! isset($_GET['receive_id'])) {
	echo json_encode(array('error' => 'Info Missing'));
	exit;
}

try {
	if( $_GET['receive_id'] == 0 ){
		//Party Chat
		$select = "SELECT * FROM `chat` 
				WHERE party_id = :party_id 
					AND receive_id = :receive_id";

		$stmt = $PDO->prepare($select);
		$result = $stmt->execute( 
			array(
				'party_id' => $_GET['party_id'],
				'receive_id' => $_GET['receive_id']
			)
		);
	}else{
		$select = "SELECT * FROM `chat` 
				WHERE party_id = :party_id 
					AND send_id = :send_id
					AND receive_id = :receive_id";

		$stmt = $PDO->prepare($select);
		$result = $stmt->execute( 
			array(
				'party_id' => $_GET['party_id'],
				'send_id' => $_GET['send_id'],
				'receive_id' => $_GET['receive_id']
			)
		);
	}
	

	$chat = $stmt->fetchAll();

	if(! empty($chat)){
		echo json_encode(array('success' => 1, 'chat' => $chat));
	}else{
		echo json_encode(array('error' => 'No Chat Found.'));
	}

}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}




