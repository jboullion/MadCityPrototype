<?php
/**
 * Sign up a new standard user
 * 
 * Called from the signup form
 */
session_start();

header("content-type:application/json");

require_once __DIR__.'/../../includes/database.php';
require_once __DIR__.'/../../includes/functions.php';
require_once __DIR__.'/../../vendor/autoload.php';


if(empty($_POST['email'])) {
	echo json_encode(array('error' => 'Email Missing'));
	exit;
}

if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo json_encode(array('error' => 'Invalid Email'));
	exit;
}

//Does this email Exist?
$select = "SELECT user_id FROM users WHERE user_email = :email LIMIT 1";
$stmt = $PDO->prepare($select);
$result = $stmt->execute( 
	array(
		'email' => $_POST['email']
	)
);

if($result){

	$user = $stmt->fetch();
	$newPassword = jb_random_password();
	$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

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
	
	$msg = "Here is your new password: {$newPassword}. You can update this password on your account page.";
	if (jb_smtpmailer($_POST['email'], 'jboullion83@gmail.com', 'Mad City', 'Forgot Password', $msg)) {
		// do something
		echo json_encode(array('success' => 'Please check your email for your new password'));
		exit;
	}else{

	}

}else{
	echo json_encode(array('error' => 'Unable to find user with that email'));
	exit;
}