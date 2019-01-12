<?php 
require_once('../setup.php');

unset($_POST['character_id']);
unset($_POST['user_id']);

//add this new power to our list of powers
$CHARACTER->powers[$_POST['power_key']] = $_POST;

// Make our character update itself in the database
$result = $CHARACTER->updatePowers();

if($result == 1){
	echo json_encode(array('success' => 'Power Edited'));
}else{
	echo json_encode(array('error' => 'Power Edit Failed'));
}