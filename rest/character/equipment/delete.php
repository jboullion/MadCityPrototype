<?php 
require_once('../setup.php');

//add this new power to our list of powers
unset($CHARACTER->equipment[$_POST['delete_key']]);

// Make our character update itself in the database
$result = $CHARACTER->updateEquipment();

if(DEBUG){
	if($result == 1){
		echo json_encode(array('success' => 'Equipment Deleted'));
	}else{
		echo json_encode(array('error' => 'Equipment Delete Failed'));
	}
}