<?php 
require_once('../setup.php');

//add this new power to our list of powers
unset($CHARACTER->powers[$_POST['delete_key']]);

// Make our character update itself in the database
$result = $CHARACTER->updatePowers();

if($result == 1){
	echo json_encode(array('success' => 'Power Deleted'));
}else{
	echo json_encode(array('error' => 'Power Delete Failed'));
}