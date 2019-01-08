<?php 
	/**
	 * Return a list of all characters for a particular user
	 * 
	 * @param int $user_id
	 */
	function jb_get_characters(PDO $PDO, $user_id){
		$select = "SELECT * FROM characters WHERE user_id = :user_id";
		$stmt = $PDO->prepare($select);
		$stmt->execute( 
			array(
				'user_id' => $user_id
			)
		);

		return $stmt->fetchAll();
	}

	/**
	 * Display a single character on the listing page
	 * 
	 * @param array $character a character array returned from the database
	 */
	function jb_display_character($character){
		if(empty($character['last_updated'])){
			$days_ago = 'Today';
		}else{
			$last_updated = new \DateTime($character['last_updated']);
			$today = new \DateTime;

			$days_ago = $last_updated->diff($today)->days.' days ago';
		}

		echo '<a href="/character/?id='.$character['character_id'].'" id="character-'.$character['character_id'].'"  class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">'.$character['character_name'].'</h5>
					<div class="delete-character list-edit" data-id="'.$character['character_id'].'"><i class="fal fa-cross"></i></div>
				</div>
				<p class="mb-1">'.$character['character_power_type'].'</p>
				<small>'.$character['character_xp'].'xp</small>
			</a>';
		
		//<small>'.$days_ago.'</small>
	}



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

		<div class="row list-controls">
			<div class="col-12">
				<button class="btn btn-primary w-100" id="add-character">+ Add Character</button>
			</div>
		</div>
	</div>
</section>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/character/actions/create-character.php'); ?>