<?php
/**
 * Sync the front and back end Google User
 * 
 * Called each time the Google SignOn method is run.
 */
header("content-type:application/json");

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';

session_start();

if(empty($_POST) || empty($_POST['email']) || empty($_POST['password'])) {
  echo json_encode(array('error' => 'Info Missing'));
}

$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

//query our db for a user with this password
//we are returning our password here so we can check against it later
$user = jb_user_exists($PDO, $_POST['email']);

if(empty($user)){
	echo json_encode(array('error' => 'We could not find a user with that email.'));
	exit;
}

//check our current password
if (password_verify($_POST['password'], $user['user_password'])) {
	// Login successful.
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['user_id'] = $user['user_id'];

	if (password_needs_rehash($user['user_password'], PASSWORD_DEFAULT)) {
		// Recalculate a new password_hash() and overwrite the one we stored previously
		$newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$update = "UPDATE `users` 
					SET `user_password` = :user_password
					WHERE `user_id` = :user_id";

		$stmt = $PDO->prepare($update);

		$result = $stmt->execute( 
			array(
				'user_password' => $newHash,
				'user_id' => $user['user_id']
			)
		);

		if(DEBUG){
			if($result){
				//updated password
				echo json_encode(array('success' => 'Password Refreshed'));
			}else{
				//failed to update password
				echo json_encode(array('error' => 'Failed to rehash password'));
			}
		}
	}

	echo json_encode(array('success' => 'Sign in Successful'));
	exit;

}else{
	echo json_encode(array('error' => 'Incorrect Password'));
	exit;
}


 





if ($payload) {
  $userid = $payload['sub'];
  // If request specified a G Suite domain:
  //$domain = $payload['hd'];
  echo json_encode(array('success' => 'Valid ID token'));
} else {
  // Invalid ID token
  echo json_encode(array('error' => 'Invalid ID token'));
}