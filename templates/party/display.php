<?php 
if( ! empty($_GET['id']) && is_numeric($_GET['id']) && ! empty($_SESSION['user_id'])){
	$PARTY = new Party($PDO, $_GET['id'], $_SESSION['user_id']);
}else{
	die('No Party Found');
}

mc_print($PARTY);
?>
<form id="party" action="" method="post">
	<input type="hidden" name="character_id" value="<?php //echo $CHARACTER->character_id; ?>" />
	<input type="hidden" name="user_id" value="<?php //echo $CHARACTER->user_id; ?>" />

	<?php //$CHARACTER->displayNames(); ?>
	<?php //$CHARACTER->displayStats(); ?>

	<section class="wrapper">
		<div class="container">
			<div class="row">
				<?php //$CHARACTER->displayPowers(); ?>
				<?php //$CHARACTER->displayEquipment(); ?>
			</div>
		</div>
	</section>
</form>