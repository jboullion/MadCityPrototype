<?php 
require_once('../setup.php');

unset($_POST['character_id']);
unset($_POST['user_id']);

//add this new power to our list of powers
$CHARACTER->equipment[] = $_POST;

// Make our character update itself in the database
$result = $CHARACTER->updateEquipment();

if($result == 1){
	echo json_encode(array('success' => 'Equipment Added'));
}else{
	echo json_encode(array('error' => 'Equipment Add Failed'));
}
