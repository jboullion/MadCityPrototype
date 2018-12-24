<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';

$insert = "INSERT INTO users (user_email, user_password, user_is_online) VALUES(:email, :password, 1)";
$stmt = $PDO->prepare($insert);
$result = $stmt->execute( 
	array(
		'email' => 'test',
		'password' => 'test' 
	)
);

jb_print($PDO->lastInsertId() );