<?php 
	/**
	 * Return a list of all characters for a particular user
	 * 
	 * @param int $user_id
	 */

	function jb_get_parties(PDO $PDO){

		$party_ids = implode(',',$_SESSION['party_ids']);
		// IN statements don't work well with PDO
		$select = "SELECT * FROM parties WHERE party_id IN ( {$party_ids} )"; //:party_ids
		
		$stmt = $PDO->prepare($select);
		$stmt->execute( );
		/*
			array(
				'party_ids' => $party_ids
			)
		*/

		$parties = $stmt->fetchAll();

		/*
		//get the party user information
		if(! empty($parties)){
			foreach($parties as $key => $party){
				$select = "SELECT `user_id`, `user_email` FROM users WHERE user_id IN ( {$party['user_ids']} )";

				$stmt = $PDO->prepare($select);
				$stmt->execute( );

				$parties[$key]['users'] = $stmt->fetchAll();
			}
		}
		*/
		
		return $parties;
	}

	/**
	 * Display a single party on the listing page
	 * 
	 * @param array $party a party array returned from the database
	 */
	function jb_display_party($party, $create = false){
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
			$controls = '<div class="edit-party list-edit" data-id="'.$party['party_id'].'" data-name="'.$party['party_name'].'" ><i class="fal fa-pencil"></i></div>';
		}else{
			$controls = '<div class="leave-party list-edit" data-id="'.$party['party_id'].'"><i class="fal fa-user-times"></i></div>';
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
		/*
		if(! empty($party['next_session'])){
			echo '<p class="mb-1">Next Session: '.date('m/d/Y @ g:ia', strtotime($party['next_session'])).'</p>';
		}
		*/

		echo '<p class="mb-1">DM: '.$dm.'</p>
			</a>';
		
		//echo '<small>Last Online: '.$days_ago.'</small>
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
<section id="party-list">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="list-group" id="party-list-target">
					<?php 
						if(! empty($parties)){
							foreach($parties as $party){
								jb_display_party($party);
							}
						}
					?>
				</div>
			</div>
		</div>

		<div class="row list-controls">
			<div class="col-12">
				<button class="btn btn-primary w-100" id="create-party"><i class="fal fa-scroll-old"></i> Create Party</button>
			</div>
			
		</div>
		<!-- 
			<div class="col-6">
				<button class="btn btn-primary w-100" id="join-party"><i class="fal fa-search"></i> Join Party</button>
			</div>
		-->
	</div>
</section>
<!-- when adding a new party we will use this template -->
<script id="party-template" type="text/template">
<?php 
	$party = array(
		'party_id' => '<%party_id%>',
		'party_name' => '<%party_name%>',
		'dm_email' => '<%dm_email%>',
		'next_session' => '',
		'last_online' => ''
	);

	jb_display_party($party, true);
?>
</script>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/join.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/create.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/party/actions/edit.php'); ?>