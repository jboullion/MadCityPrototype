<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/chat-functions.php'); ?>
<div id="party" class="page">
	<?php 
		//$PARTY->displayNames(); 
		echo '<script>var BASE_DIR = "/"; var party_id = '.$PARTY->party_id.'; var user_id = '.$_SESSION['user_id'].';</script>'; 
	?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/common/top-nav.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/sections/party.php'); ?>
	<?php 
		/*
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
		*/
	?>
</div>
<script id="chat-template" type="text/template">
<?php 
	mc_display_message();
?>
</script>
<?php //require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/add-player.php'); ?>
<?php //require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/remove-player.php'); ?>