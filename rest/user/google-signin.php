<?php
/**
 * Sync the front and back end Google User
 * 
 * Called each time the Google SignOn method is run.
 */
header("content-type:application/json");

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../../includes/database.php';

session_start();

if(empty($POST['id_token'])){
  echo json_encode(array('error' => 'Missing ID token'));
  die();
}


$id_token = $_POST['id_token'];

//Found on Google Auth Console and in client_secrets.json
//TODO: Move this to 
$CLIENT_ID = '63734584828-cpm6irahebhdeq12o019v5ep90lmlrkf.apps.googleusercontent.com';


$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
  // If request specified a G Suite domain:
  //$domain = $payload['hd'];
  echo json_encode(array('success' => 'Valid ID token'));
} else {
  // Invalid ID token
  echo json_encode(array('error' => 'Invalid ID token'));
}