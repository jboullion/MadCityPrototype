<?php 
// TODO: Need to setup sessions and make sure the user is logged in to reach here.
// 		 This could probably wait until react move?

// Check our data first
if(empty($_POST['character_id']) || ! is_numeric($_POST['character_id'])
	|| empty($_POST['user_id']) || ! is_numeric($_POST['user_id'])) {

	echo json_encode(array('error' => 'ID Missing'));
	exit;
}

header("content-type:application/json");

//require_once('../includes/classes/Utilities.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/classes/Character.php');

//$utility = new Utilities();
$CHARACTER = new Character($PDO, $_POST['character_id'], $_POST['user_id']);