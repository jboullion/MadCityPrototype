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

if(empty($_POST['id_token'])){
	echo json_encode(array('error' => 'Missing ID token'));
	die();
}

echo jbGoogleSignIn($PDO, $_POST['id_token'], $_POST['email']);
exit;