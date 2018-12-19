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