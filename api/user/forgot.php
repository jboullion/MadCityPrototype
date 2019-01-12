<?php
/**
 * Sign up a new standard user
 * 
 * Called from the signup form
 */
session_start();

header("content-type:application/json");

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


if(empty($_POST['email'])) {
	echo json_encode(array('error' => 'Email Missing'));
	exit;
}

if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo json_encode(array('error' => 'Invalid Email'));
	exit;
}

//Does this email Exist?
$user = mc_user_exists($PDO, $_POST['email']);

if(! empty($user)){

	$newPassword = mc_random_password();
	$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

	try{
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
	}catch(PDOException $e){
		error_log($e->getMessage(), 0);
	}


	$msg = "Here is your new password: {$newPassword}. You can update this password on your account page.";
	if (mc_smtpmailer($_POST['email'], ADMIN_EMAIL, 'Mad City', 'Forgot Password', $msg)) {
		// do something
		echo json_encode(array('success' => 'Please check your email for your new password'));
		exit;
	}else{

	}

}else{
	echo json_encode(array('error' => 'Unable to find user with that email'));
	exit;
}