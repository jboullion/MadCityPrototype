<?php
// functions used throuhgout the site
require_once('includes/functions.php');

if(! empty($_SESSION['email'])){
	jb_redirect('/character/');
	exit;
}

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
		<?php require_once('templates/login/login.php'); ?>
		<?php require_once('templates/common/footer.php'); ?>
	</body>
</html>