<?php

// functions used throuhgout the site
require_once('includes/functions.php');

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


// All Classes loaded here
require_once('includes/classes.php');

// Database connection 
require_once('includes/setup.php');
?>
<!doctype html>
<html lang="en">
	<?php require_once('templates/common/header.php'); ?>
	<body>
		<?php require_once('templates/common/navigation.php'); ?>
		<div class="g-signin2" data-onsuccess="onSignIn"></div>
		<a href="#" onclick="signOut();">Sign out</a>
		<?php require_once('templates/character/sheet.php'); ?>
		<?php require_once('templates/character/actions/actions.php'); ?>
		<?php require_once('templates/common/footer.php'); ?>

		<script>
			function signOut() {
				var auth2 = gapi.auth2.getAuthInstance();
				auth2.signOut().then(function () {
				console.log('User signed out.');
				});
			}

			function onSignIn(googleUser) {
				var profile = googleUser.getBasicProfile();
				console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
				console.log('Name: ' + profile.getName());
				console.log('Image URL: ' + profile.getImageUrl());
				console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
			}
		</script>
	</body>
</html>