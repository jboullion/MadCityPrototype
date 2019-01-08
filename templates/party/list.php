<?php 
	/**
	 * Return a list of all characters for a particular user
	 * 
	 * @param int $user_id
	 */

	function jb_get_parties(PDO $PDO){

		$select = "SELECT * FROM parties WHERE party_id IN (:party_ids)";
		
		$stmt = $PDO->prepare($select);
		$stmt->execute( 
			array(
				'party_ids' => implode(',',$_SESSION['party_ids'])
			)
		);

		return $stmt->fetchAll();
	}

	/**
	 * Display a single party on the listing page
	 * 
	 * @param array $party a party array returned from the database
	 */
	function jb_display_parties($party){
		if(empty($party['last_online'])){
			$days_ago = 'Today';
		}else{
			$last_updated = new \DateTime($party['last_online']);
			$today = new \DateTime;

			if($last_updated->diff($today)->days < 1){
				$days_ago = 'Today';
			}else{
				$days_ago = $last_updated->diff($today)->days.' days ago';
			}
			
		}

		echo '<a href="/party/?id='.$party['party_id'].'" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">'.$party['party_name'].'</h5>
					<small>DM: '.mc_get_userinfo($party['dm_id'], 'user_email').'</small>
				</div>
				<p class="mb-1">Next Session: '.date('m/d/Y @ g:ia', strtotime($party['next_session'])).'</p>
				<small>Last Session: '.$days_ago.'</small>
			</a>';
	}

	/**
	 * Get information about a user.
	 * 
	 * @param int $user_id The ID of the user to get info about
	 * @param string $column The column name of the info you want 
	 */
	function mc_get_userinfo($user_id, $column){
		global $PDO;

		$select = "SELECT $column FROM users WHERE user_id = :user_id LIMIT 1";
		$stmt = $PDO->prepare($select);
		$stmt->execute( 
			array(
				'user_id' => $user_id
			)
		);

		$result = $stmt->fetch();

		return $result[$column];

	}



	$parties = jb_get_parties($PDO, $_SESSION['party_ids']);
?>
<section id="character-list">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="list-group" id="character-list-target">
					<?php 
						if(! empty($parties)){
							foreach($parties as $party){
								jb_display_parties($party);
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