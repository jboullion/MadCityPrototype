<?php

// database setup
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

// functions used throuhgout the site
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

if(empty($_GET['id'])){
	mc_redirect('/party/');
	exit;
}

// check user sessions
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/session.php');

// All Classes loaded here
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/classes.php');
?>
<!doctype html>
<html lang="en">
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/header.php'); ?>
	<body>
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/navigation.php'); ?>
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/view.php'); ?>
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/footer.php'); ?>
	</body>
</html>