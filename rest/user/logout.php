<?php 

session_start();

header("content-type:application/json");

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

//Destroy anything tracking this user
unset($_SESSION['email']);
unset($_SESSION['user_id']);
session_destroy();

//Destroy Cookies: Nom Nom
setcookie("google-idtoken", "");
setcookie("email", "");

//not needed
unset($_COOKIE['google-idtoken']);
unset($_COOKIE['email']);

try{
	$update = "UPDATE `users` 
	SET `user_is_online` = 0
	WHERE `user_email` = :email";

	$stmt = $PDO->prepare($update);

	$result = $stmt->execute( 
		array(
			'email' => $_POST['email']
		)
	);	

	if($result){
		echo json_encode(array('success' => 'User Logged Out'));
		exit;
	}else{
		echo json_encode(array('error' => 'Could not log user out'));
		exit;
	}
}catch(PDOException $e){
	//echo json_encode(array('error' => $e->getMessage()));
}

echo json_encode(array('error' => 'Could not log user out'));
exit;