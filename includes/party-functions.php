<?php 
/**
	* Return a list of all characters for a particular user
	* 
	* @param int $user_id
	*/

function mc_get_parties(PDO $PDO){
	try{
		// IN statements don't work well with PDO
		$select = "SELECT p.* FROM party_characters AS pc 
			LEFT JOIN parties AS p ON p.party_id = pc.party_id
			WHERE pc.user_id = :user_id ";
		$stmt = $PDO->prepare($select);
		$stmt->execute( 
			array(
				'user_id' => $_SESSION['user_id']
			)
		);

		$parties = $stmt->fetchAll();

		return $parties;
	}catch(PDOException $e){
		error_log($e->getMessage(), 0);
		return array();
	}
}

/**
	* Display a single party on the listing page
	* 
	* @param array $party a party array returned from the database
	*/
function mc_display_party($party, $create = false){
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

	
	//data-users=\''.json_encode($party['users']).'\' 

	// DM controls vs player controls
	if($create || $_SESSION['user_id'] === $party['dm_id'] ){
		$controls = '<div class="edit-party list-edit" data-id="'.$party['party_id'].'" data-name="'.$party['party_name'].'" ><i class="far fa-pencil"></i></div>';
	}else{
		$controls = '<div class="leave-party list-edit" data-id="'.$party['party_id'].'"><i class="far fa-user-times"></i></div>';
	}

	if($create){
		$dm = $party['dm_email'];
		$party_name = $party['party_name'];
	}else{
		$dm = mc_get_userinfo($party['dm_id'], 'user_email');
		$party_name = htmlspecialchars($party['party_name']);
	}

	echo '<a href="/party/?id='.$party['party_id'].'" id="party-'.$party['party_id'].'" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1">'.$party_name.'</h5>
				'.$controls.'
			</div>';

	echo '<p class="mb-1">DM: '.$dm.'</p>
		</a>';

}