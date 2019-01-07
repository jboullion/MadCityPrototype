<?php
session_start();

// database setup
require_once('includes/database.php');

// functions used throuhgout the site
require_once('includes/functions.php');

//Log in if our sessions is still set
if(! empty($_SESSION['email']) ){
	// jb_print('_SESSION');
	// jb_print($_SESSION);
	jb_redirect('/character/');
	exit;
}


//check our google cookie to see if we can redirect before loading the page
if(! empty($_COOKIE['google-idtoken']) && ! empty($_COOKIE['email'])){
	$result = json_decode(jbGoogleSignIn($PDO, $_COOKIE['google-idtoken'], $_COOKIE['email']), TRUE);
	if(! empty($result['success'])){
		jb_redirect('/character/');
		exit;
	}
}


// All Classes loaded here
require_once('includes/classes.php');
?>
<!doctype html>
<html lang="en">
	<?php require_once('templates/common/header.php'); ?>
	<body>
		<?php require_once('templates/common/navigation.php'); ?>
		<?php require_once('templates/login/login.php'); ?>
		<?php require_once('templates/common/footer.php'); ?>
	</body>
</html>