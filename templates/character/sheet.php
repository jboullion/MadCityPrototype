<form id="character-sheet" action="" method="post">
<input type="hidden" name="character_id" value="<?php echo $CHARACTER->character_id; ?>" />
<input type="hidden" name="user_id" value="<?php echo $CHARACTER->user_id; ?>" />

<?php $CHARACTER->displayNames(); ?>
<?php $CHARACTER->displayStats(); ?>

<section class="wrapper">
	<div class="container">
		<div class="row">
			<?php //require_once('powers.php'); ?>
			<?php //require_once('equipment.php'); ?>
		</div>
	</div>
</section>
</form>