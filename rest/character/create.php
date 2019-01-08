<?php 
/**
 * Create a character and have them connected to a user
 */
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

header("content-type:application/json");

if(empty($_POST) || empty($_POST['user_id']) || empty($_POST['character_name'])) {
	echo json_encode(array('error' => 'Info Missing'));
}

try{
	$insert = "INSERT INTO `characters`(`user_id`, `character_name`) 
	VALUES (:user_id,:character_name)";
	$stmt = $PDO->prepare($insert);
	$result = $stmt->execute( 
		array(
			'user_id' => $_POST['user_id'],
			'character_name' => $_POST['character_name']
		)
	);

}catch(PDOException $e){
	//echo $sql . "<br>" . $e->getMessage();
}


if(! empty($result)){
	echo json_encode(array('success' => 'Character created successfully', 'character_id' => $PDO->lastInsertId()));
}else{
	echo json_encode(array('error' => 'Character could not be created'));
}

