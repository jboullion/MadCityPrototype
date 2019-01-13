<?php 
/**
 * Send chat message to DB
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) 
	|| empty($_SESSION['user_id']) 
	|| empty($_POST['party_id']) 
	|| ! isset($_POST['receive_id']) 
	|| empty($_POST['player_chat']) 
	|| empty($_POST['send_name']) 
	|| empty($_POST['receive_name']) 
) {
	echo json_encode(array('error' => 'Info Missing'));
	exit;
}


try {

	$insert = 
	"INSERT INTO `chat` ( `party_id`, `send_id`, `receive_id`, `send_name`, `receive_name`, `content` ) 
	VALUES ( :party_id, :send_id, :receive_id, :send_name, :receive_name, :content )";

	$stmt = $PDO->prepare($insert);
	$result = $stmt->execute(
		array(
			'party_id' => $_POST['party_id'],
			'send_id' => $_POST['send_id'],
			'receive_id' => $_POST['receive_id'],
			'send_name' => $_POST['send_name'],
			'receive_name' => $_POST['receive_name'],
			'content' => $_POST['player_chat']
		)
	);

}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}


if(! empty($result)){
	echo json_encode(array('success' => 'Message Sent'));
}else{
	echo json_encode(array('error' => 'Not Received'));
}