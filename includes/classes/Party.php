<?php 
/**
 * A Party Object
 */
class Party { 
	// PDO Object with connection to DB
	var $PDO;

	// The IDs of the party and user in the database
	var $party_id;
	var $dm_id;
	var $dm_email;

	var $name; 
	var $total_xp; 
	var $players = array();

	function __construct($PDO, $party_id, $user_id) {
		$this->PDO = $PDO;

		$this->party_id = $party_id;

		// GET the party as lon as this user is a member of the party
		try{
			$stmt = $this->PDO->prepare("SELECT * FROM parties WHERE party_id = :party_id AND user_ids LIKE :user_id LIMIT 1");
			$stmt->execute( array('party_id' => $party_id, 'user_id' => '%'.$user_id.'%') );
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
					$this->players = $players;
				}
				
			}catch(PDOException $e){
				error_log($e->getMessage(), 0);
			}
		}

		$this->name = $party['party_name'];
		$this->total_xp = $party['total_xp'];
		$this->dm_id = $party['dm_id'];
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
	 * Display the list of players
	 */
	function displayPlayers(){ ?>
		<div class="list-group" id="party-list-target">
			<?php 
				if(! empty($this->players)){
					foreach($this->players as $player){
						$this->displayPlayer($player);
					}
				}
			?>
		</div>
		<?php 
	}

	/**
	 * Display a single player
	 */
	function displayPlayer($player, $create = false){
		$controls = '<a href="/character/view/?id='.$player['character_id'].'" class="view-player player-edit" data-id="'.$player['character_id'].'"><i class="far fa-eye"></i></a>';

		// DM controls
		if($_SESSION['user_id'] === $this->dm_id && $player['user_id'] !== $this->dm_id ){
			$controls .= '<div class="remove-player player-edit" data-id="'.$player['user_id'].'" data-email="'.$player['user_email'].'" ><i class="far fa-user-minus"></i></div>';
		}

		echo '<div href="#" id="player-'.$player['user_id'].'" class="player list-group-item list-group-item-action">
				<div class="w-100">
					'.$controls.'
					<h5 class="mb-1">'.$player['character_name'].'</h5>
					<small>'.$player['user_name'].'</small>
				</div>
			</div>';
	}

}