<?php 

session_start();

header("content-type:application/json");

require_once __DIR__.'/../../includes/database.php';
require_once __DIR__.'/../../includes/functions.php';
require_once __DIR__.'/../../vendor/autoload.php';

session_destroy();

if(empty($_POST['email'])) {
	echo json_encode(array('error' => 'Info Missing'));
	exit;
}

if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo json_encode(array('error' => 'Invalid Email'));
	exit;
}

$update = "UPDATE `users` 
			SET `user_is_online` = 0
			WHERE `email` = :email";

$stmt = $PDO->prepare($update);

$result = $stmt->execute( 
	array(
		'email' => $_POST['email']
	)
);