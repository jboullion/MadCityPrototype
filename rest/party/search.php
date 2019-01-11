<?php 
/**
 * DELETE party
 */
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/classes/Party.php');

header("content-type:application/json");

if(empty($_GET) || empty($_GET['player_search']) || empty($_GET['party_id']) || empty($_GET['user_id']) ) {
	echo json_encode(array('error' => 'Info Missing'));
}

try {
	//Find any users who are not already in the party
	$select = "SELECT u.user_id, u.user_name FROM `users` AS u
				WHERE u.user_name LIKE :user_name 
					AND u.user_id != :user_id 
				ORDER BY u.user_name LIMIT 20";
	//OR `user_email` LIKE :user_name 

	$stmt = $PDO->prepare($select);
	$result = $stmt->execute( 
		array(
			'user_name' => $_GET['player_search'].'%',
			'user_id' => $_GET['user_id'],
		)
	);

	$users = $stmt->fetchAll();

	if(! empty($users)){

		//let's check the party to make sure this person isn't already in the party
		$PARTY = new Party($PDO, $_GET['party_id'], $_GET['user_id']);
		if(! empty($PARTY->players)){
			//I don't love these double loops, but since we limit to 20 results anyway should be ok for now
			foreach($PARTY->players as $player){
				foreach($users as $key => $user){
					if($user['user_id'] === $player['user_id']){
						unset($users[$key]);
					}
				}
			}
		}
		
		echo json_encode(array('success' => 'Users found.', 'users' => $users));
	}else{
		echo json_encode(array('error' => 'No Users Found.'));
	}
	
}catch(PDOException $e){
	error_log($e->getMessage(), 0);
}




