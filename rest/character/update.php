<?php 
// TODO: Need to setup sessions and make sure the user is logged in to reach here.
// 		 This could probably wait until react move?

// Check our data first
if(empty($_POST['character_id']) || ! is_numeric($_POST['character_id'])
	|| empty($_POST['user_id']) || ! is_numeric($_POST['user_id'])) {

	header("HTTP/1.1 401 Unauthorized");
	exit;
}

header("content-type:application/json");

//require_once('../../includes/classes/Utilities.php');
require_once('../../includes/database.php');
require_once('../../includes/classes/Character.php');

//$utility = new Utilities();
$CHARACTER = new Character($PDO, $_POST['character_id'], $_POST['user_id']);

//$utility->print($_POST['character_id']);

$result = $CHARACTER->update($_POST);

if(DEBUG){
	if($result == 1){
		echo json_encode(array('success' => 'Character Updated'));
	}else{
		echo json_encode(array('error' => 'X Character Update Failed X'));
	}
}