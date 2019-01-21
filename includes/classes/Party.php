<?php 
/**
 * A Party Object
 */
class Party {

	// PDO Object with connection to DB
	public $PDO;

	// The IDs of the party and user in the database
	public $party_id;
	public $dm_id;
	public $dm_email;
	public $receive_id = 0;

	public $name; 
	public $total_xp; 
	public $players = array();
	public $log = '';


	function __construct($PDO, $party_id, $user_id) {
		$this->PDO = $PDO;

		$this->party_id = $party_id;

		// GET the party if this user is a member of the party
		try{
			$stmt = $this->PDO->prepare("SELECT * FROM parties AS p
			LEFT JOIN party_characters AS pc ON pc.party_id = p.party_id
			WHERE p.party_id = :party_id
				AND pc.user_id = :user_id
			LIMIT 1");
			$stmt->execute( array('party_id' => $party_id, 'user_id' => $user_id) );
			$party = $stmt->fetch();

		}catch(PDOException $e){
			error_log($e->getMessage(), 0);
		}

		if(! empty($party)){
			try{
				$stmt = $this->PDO->prepare("SELECT c.character_id, c.character_name, c.character_img , u.user_id, u.user_name, u.user_email FROM party_characters AS pc
					LEFT JOIN characters AS c ON c.character_id = pc.character_id
					LEFT JOIN users AS u ON u.user_id = pc.user_id
						WHERE pc.party_id = :party_id");
				$stmt->execute( array('party_id' => $party_id) );
				$players = $stmt->fetchAll();

				if(! empty($players)){
					foreach($players as $player){
						if(empty($player['character_id'])){
							$player['character_id'] = 0;
							$player['character_name'] = 'Game Master';
							$player['character_img'] = '';
						}

						$this->players[] = $player;
					}
					
				}

			}catch(PDOException $e){
				error_log($e->getMessage(), 0);
			}
		}

		$this->name = $party['party_name'];
		$this->total_xp = $party['total_xp'];
		$this->dm_id = $party['dm_id'];
		$this->log = $party['party_log'];
		$this->dm_email = mc_get_userinfo($party['dm_id'], 'user_email');

		
/*
		if(! empty($party['user_ids'])){
			$players = explode(',',$party['user_ids']);
			foreach($players as $user_id){
				$this->players[] = mc_get_user($PDO, $user_id);
			}
		}
*/
	}


	/**
	 * Lazy man's get method
	 * 
	 * @param string $prop_name The name of the property you want to get
	 */
	function getProp($prop_name){
		return $this->{$prop_name};
	}


	/**
	 * Lazy man's set method
	 * 
	 * @param string $prop_name The name of the property you want to set
	 * @param mixed $value The value of the property you want to set
	 */
	function setProp($prop_name, $value){
		$this->{$prop_name} = $value;
	}


	/**
	 * Display the Name and XP
	 */
	function displayNames(){
		$display_names = array(
			'name' => 'Party Name',
			'total_xp' => 'Total XP',
		); ?>
		<div class="wrapper">
			<div class="container">
				<div class="row">

		<?php foreach($display_names as $prop => $display_name): ?>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="party_<?php echo $prop; ?>"><?php echo $display_name; ?></label>
					<input type="text" class="form-control party-save" id="party_<?php echo $prop; ?>" name="party[<?php echo $prop; ?>]" value="<?php echo $this->getProp($prop); ?>">
				</div>
			</div>
		<?php endforeach; ?>

				</div>
			</div>
		</div>
		<?php 
	}

	/**
	 * Get the Character Name of a member in this party by their user name
	 */
	function getCharacterNameByUserID($user_id){
		if($user_id === $this->dm_id){
			return 'Game Master';
		}

		if(! empty($this->players)){
			foreach($this->players as $player){
				if($player['user_id'] === $user_id){
					return $player['character_name'];
				}
			}
		}
	}

	/**
	 * Display a single player
	 * 
	 * @param array $player Player array from the database
	 */
	function displayPlayer($player){
		$controls = '';

		// DM controls
		if($_SESSION['user_id'] === $this->dm_id && $player['user_id'] !== $this->dm_id ){
			$controls .= '<div class="remove-player player-edit" data-id="'.$player['user_id'].'" data-email="'.$player['user_email'].'" ><i class="far fa-user-minus"></i></div>';
		}

		//View Character
		if(! empty($player['character_id']) ){
			//Some users have not selected the character to use for this party
			$controls .= '<a href="/character/view/?id='.$player['character_id'].'" class="view-player player-edit d-print-none" data-id="'.$player['character_id'].'"><i class="far fa-eye"></i></a>';
		}

		// Who is the user
		$whoami = '';
		if($_SESSION['user_id'] === $player['user_id'] ){
			$whoami = '<i class="far fa-crown"></i> ';
			$controls = '<a href="/character/?id='.$player['character_id'].'" class="view-player player-edit d-print-none" data-id="'.$player['character_id'].'"><i class="far fa-pencil"></i></a>';
		}

		$player_name = $player['user_id'] !== $this->dm_id?$player['character_name']:'<span style="color: #8c0007;">Game Master</span>';

		echo '<div href="#" id="player-'.$player['user_id'].'" class="player list-group-item list-group-item-action">
				<div class="w-100">
					'.$controls.'
					<h5 class="mb-1">'.$whoami.$player_name.'</h5>
					<small>'.$player['user_name'].'</small>
				</div>
			</div>';
	}

}