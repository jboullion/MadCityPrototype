<?php
/**
 * Sign up a new standard user
 * 
 * Called from the signup form
 */
header("content-type:application/json");

require_once __DIR__.'/../../includes/database.php';
require_once __DIR__.'/../../includes/functions.php';

if(empty($_POST) || empty($_POST['email']) || empty($_POST['password'])) {
	echo json_encode(array('error' => 'Info Missing'));
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
	echo json_encode(array('error' => 'Email Address already Exists'));
	exit;
}

//Insert our new account
$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$insert = "INSERT INTO users (user_email, user_password, user_is_online) VALUES(:email, :password, 1)";
$stmt = $PDO->prepare($insert);
$result = $stmt->execute( 
	array(
		'email' => $_POST['email'],
		'password' => $passwordHash 
	)
);

// return our results
if($result){
	echo json_encode(array('success' => 'Account Created'));

	session_start();
	$_SESSION['email'] = $_POST['email'];

}else{
	echo json_encode(array('error' => 'Unable to create account'));
}