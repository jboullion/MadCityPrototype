<?php
// database setup
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

// functions used throuhgout the site
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

// check user sessions
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/session.php');

// All Classes loaded here
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/classes.php');

if( ! empty($_GET['id']) && is_numeric($_GET['id']) && ! empty($_SESSION['user_id'])){
	$PARTY = new Party($PDO, $_GET['id'], $_SESSION['user_id']);
}else{
	mc_redirect('/parties/');
	exit;
}
?>
<!doctype html>
<html lang="en">
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/header.php'); ?>
	<body>
		<div class="page-wrapper d-flex">
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/navigation.php'); ?>
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/slack.php'); ?>
			<?php //require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/display.php'); ?>
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/footer.php'); ?>
		</div>
	</body>
</html>