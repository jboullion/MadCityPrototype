<?php 

session_start();

header("content-type:application/json");

require_once __DIR__.'/../../includes/database.php';
require_once __DIR__.'/../../includes/functions.php';
require_once __DIR__.'/../../vendor/autoload.php';

//Destroy anything tracking this user
unset($_SESSION['email']);
session_destroy();

setcookie("google-idtoken", "", time() - 3600);
setcookie("email", "", time() - 3600);

//not needed
unset($_COOKIE['google-idtoken']);
unset($_COOKIE['email']);

$update = "UPDATE `users` 
			SET `user_is_online` = 0
			WHERE `user_email` = :email";

$stmt = $PDO->prepare($update);

$result = $stmt->execute( 
	array(
		'email' => $_POST['email']
	)
);

echo json_encode(array('success' => 'User Logged Out'));