<?php 
	$characters = jb_get_characters($PDO, $_SESSION['user_id']);
?>
<section id="character-list">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="list-group" id="character-list-target">
					<?php 
						if(! empty($characters)){
							foreach($characters as $character){
								jb_display_character($character);
							}
						}
					?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<button class="btn btn-primary w-100" id="join-party">Join Party</button>
			</div>
		</div>
	</div>
</section>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/actions/create-character.php'); ?>