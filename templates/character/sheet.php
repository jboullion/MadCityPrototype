<?php 
if( ! empty($_GET['id']) && is_numeric($_GET['id']) && ! empty($_SESSION['user_id'])){
	$CHARACTER = new Character($PDO, $_GET['id'], $_SESSION['user_id']);
}else{
	die('No Character Found');
}
?>
<form id="character-sheet" action="" method="post">
	<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
	<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />

	<?php $CHARACTER->displayNames(); ?>
	<?php $CHARACTER->displayStats(); ?>

	<section class="wrapper">
		<div class="container">
			<div class="row">
				<?php $CHARACTER->displayPowers(); ?>
				<?php $CHARACTER->displayEquipment(); ?>
			</div>
		</div>
	</section>
</form>