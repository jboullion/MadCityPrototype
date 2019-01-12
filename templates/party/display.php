<?php 
if( ! empty($_GET['id']) && is_numeric($_GET['id']) && ! empty($_SESSION['user_id'])){
	$PARTY = new Party($PDO, $_GET['id'], $_SESSION['user_id']);
}else{
	die('No Party Found');
}

//mc_print($PARTY);
?>
<div id="party">
	<?php $PARTY->displayNames(); ?>

	<section class="wrapper">
		<div class="container">
			<div class="row">
				<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/sections/log.php'); ?>
				<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/sections/players.php'); ?>
			</div>
			<div class="row">
				<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/sections/chat.php'); ?>
			</div>
		</div>
	</section>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/add-player.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/remove-player.php'); ?>