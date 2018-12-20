<?php 
require_once('database.php');

$user_id = 1;
$character_id = 1;

// Setup the current user on the site
$USER = site_get_user($PDO, $user_id);

// Setup the current character on the site
$CHARACTER = new Character($PDO, $character_id, $user_id);

define('BASE_URL', $_SERVER['proto'].'://'.$_SERVER['HTTP_HOST']);


/*
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/vendor/autoload.php';

session_start();


$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $gmail = new Google_Service_Gmail($client);

  // Print the labels in the user's account.
	$user = 'me';
	$results = $gmail->users_labels->listUsersLabels($user);

	if (count($results->getLabels()) == 0) {
		print "No labels found.\n";
	} else {
		print "Labels:\n";
		foreach ($results->getLabels() as $label) {
			printf("- %s\n", $label->getName());
		}
	}

  die();

} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
*/