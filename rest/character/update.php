<?php 
require_once('setup.php');

//$utility->print($_POST['character_id']);

$result = $CHARACTER->updateStats($_POST);

if(DEBUG){
	if($result == 1){
		echo json_encode(array('success' => 'Character Updated'));
	}else{
		echo json_encode(array('error' => 'Character Update Failed'));
	}
}