<?php
/**
 * Sync the front and back end Google User
 * 
 * Called each time the Google SignOn method is run.
 */
header("content-type:application/json");

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../includes/database.php';

session_start();

if(empty($_POST['id_token'])){
	echo json_encode(array('error' => 'Missing ID token'));
	die();
}

$id_token = $_POST['id_token'];

$client = new Google_Client(['client_id' => CLIENT_ID]);
$payload = $client->verifyIdToken($id_token);
if ($payload) {
	//Valid ID Token
	//Now try to log in

	//this should not be able to happen. Trust Google.
	if(empty($_POST['email'])) {
		echo json_encode(array('error' => 'Info Missing'));
		exit;
	}

	//this should not be able to happen. Trust Google.
	if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo json_encode(array('error' => 'Invalid Email'));
		exit;
	}

	//Does this email Exist already?
	$user = jb_user_exists($PDO, $_POST['email']);

	// TODO: Should we separate the Google account from other accounts? 
	// Would we allow 2 of the same emails if so?
	// One a google user and one a custom user?
	if(! empty($user)){
		//User Exists, log into it
		$_SESSION['email'] = $_POST['email'];
		echo json_encode(array('success' => 'Sign in Successful'));
	}else{
		//User Doesn't Exist...Sign them up!
		$insert = "INSERT INTO users (user_email, user_google_token, user_is_online) VALUES(:email, :password, 1)";
		$stmt = $PDO->prepare($insert);
		$result = $stmt->execute( 
			array(
				'email' => $_POST['email'],
				'user_google_token' => $id_token 
			)
		);

		if($result){
			$_SESSION['email'] = $_POST['email'];
			echo json_encode(array('success' => 'Google User Created'));
		}else{
			echo json_encode(array('error' => 'Couldn\t create the Google User'));
		}
	}

} else {
	// Invalid ID token
	echo json_encode(array('error' => 'Invalid ID token'));
}