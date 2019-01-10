<?php 
if( ! empty($_GET['id']) && is_numeric($_GET['id'])){
	$CHARACTER = new Character($PDO, $_GET['id']);
}else{
	die('No Character Found');
}
?>
<div id="character-sheet">
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
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/actions/edit-power.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/actions/edit-equipment.php'); ?>