<?php 
/**
 * A Character Object
 * 
 * NOTE: I probably could have condensed all the vitals / stats into an array instead of a bunch of independent properties, but I currently think it is better to have the properties separate for now
 */
class Character { 
	// PDO Object with connection to DB
	var $PDO;

	// The IDs of the character and user in the database
	var $character_id;
	var $user_id;
	var $view;

	// name
	var $name; 
	var $hero_name;
	var $power_type;
	var $total_xp;

	// vitals
	var $vitals = array(
		'physical' => array(
			'health' => 'Health',
			'power' => 'Power'
		),
		'mental' => array(
			'health_regen' => 'Health Regen',
			'power_regen' => 'Power Regen'
		),
		'personality' => array(
			'durability' => 'Durability',
			'resistance' => 'Resistance'
		)
	);

	var $health;
	var $power;
	var $health_regen;
	var $power_regen;
	var $durability;
	var $resistance;

	// stats
	var $stats = array(
		'physical' => array(
			'strength' => 'Strength',
			'dexterity' => 'Dexterity',
			'stamina' => 'Stamina'
		),
		'mental' => array(
			'intelligence' => 'Intelligence',
			'perception' => 'Perception',
			'wisdom' => 'Wisdom'
		),
		'personality' => array(
			'charisma' => 'Charisma',
			'leadership' => 'Leadership',
			'will' => 'Will'
		)
	);

	var $strength;
	var $dexterity;
	var $stamina;
	var $intelligence;
	var $perception;
	var $wisdom;
	var $charisma;
	var $leadership;
	var $will;

	// skills
	var $skills = array(
		'physical' => array(
			'melee' => 'Melee',
			'stealth' => 'Stealth',
			'dodge' => 'Dodge',
			'fire_arms' => 'Fire Arms'
		),
		'mental' => array(
			'investigate' => 'Investigate',
			'medicine' => 'Medicine',
			'computers' => 'Computers',
			'science' => 'Science'
		),
		'personality' => array(
			'romance' => 'Romance',
			'persuasion' => 'Persuasion',
			'intimidation' => 'Intimidation',
			'alertness' => 'Alertness'
		)
	);

	var $melee;
	var $stealth;
	var $dodge;
	var $fire_arms;
	var $investigate;
	var $medicine;
	var $computers;
	var $science;
	var $romance;
	var $persuasion;
	var $intimidation;
	var $alertness;

	// dynamic sets of abilities
	var $powers;
	var $equipment;

	var $slots = array(
		'head' => 'Head',
		'torso' => 'Torso',
		'hands' => 'Hands',
		'legs' => 'Legs',
		'feet' => 'Feet',
		'accessory'  => 'Accessory'
	);

	// 'one_hand'  => '1 Hand',
	// 'two_hand'  => '2 Hands',

	var $effects = array(
		'None',
		'Blind',
		'Bloodlust',
		'Burned',
		'Charm',
		'Confuse',
		'Crippled',
		'Disable',
		'Infected',
		'Insanity',
		'Mind Control'
	);

	var $damage = array(0,4,8,12,16,20);

	var $types = array(
		'Air',
		'Animal',
		'Blood',
		'Earth',
		'Fire',
		'Gravity',
		'Illusion',
		'Light',
		'Psychic',
		'Physical',
		'Radiation',
		'Shape Shift',
		'Speed',
		'Water',
		'Weather'
	);

	var $levels = array(1,2,3,4,5);

	var $combinedstats = array();

	/**
	 * @param array $character The results of a 
	 */
	function __construct($PDO, $character_id, $user_id = 0) {
		$this->PDO = $PDO;

		$this->character_id = $character_id;
		$this->user_id = $user_id;

		if(! empty($user_id)){
			//Edit Character
			$this->view = false;
			try{
				$stmt = $this->PDO->prepare("SELECT * FROM characters WHERE character_id = :character_id AND user_id = :user_id LIMIT 1");
				$stmt->execute( array('character_id' => $character_id, 'user_id' => $user_id) );
				$character = $stmt->fetch();
			}catch(PDOException $e){
				error_log($e->getMessage(), 0);
			}
		}else{
			//View character
			$this->view = true;
			try{
				$stmt = $this->PDO->prepare("SELECT * FROM characters WHERE character_id = :character_id LIMIT 1");
				$stmt->execute( array('character_id' => $character_id) );
				$character = $stmt->fetch();
			}catch(PDOException $e){
				error_log($e->getMessage(), 0);
			}

		}

		$this->name = $character['character_name'];
		$this->mutant_name = $character['character_mutant_name'];
		$this->power_type = $character['character_power_type'];
		$this->xp = $character['character_xp'];

		if(empty($character['character_stats'])){
			$character_stats = array();
		}else{
			$character_stats = json_decode($character['character_stats'], true);
		}

		if(empty($character['character_powers'])){
			$this->powers = array();
		}else{
			$this->powers = json_decode($character['character_powers'], true);
		}

		if(empty($character['character_equipment'])){
			$this->equipment = array();
		}else{
			$this->equipment = json_decode($character['character_equipment'], true);
		}

		//dynamically assign our values...clever or dangerous?...BOTH! ;)
		foreach($character_stats as $key => $value){
			$this->{$key} = $value;
		}

		foreach($this->vitals as $type){
			foreach($type as $key => $value){
				$this->combinedstats[$key] = $value;
			}
		}

		foreach($this->stats as $type){
			foreach($type as $key => $value){
				$this->combinedstats[$key] = $value;
			}
		}

		foreach($this->skills as $type){
			foreach($type as $key => $value){
				$this->combinedstats[$key] = $value;
			}
		}

		asort($this->combinedstats);
	}


	/**
	 * Take the data submitted from the form
	 * 
	 * @param array $data The character form data
	 */
	function updateStats($data){

		try{
			$update = 
			"UPDATE `characters`   
				SET `character_name` = :character_name,
					`character_mutant_name` = :character_mutant_name,
					`character_power_type` = :character_power_type,
					`character_xp` = :character_xp,
					`character_stats` = :character_stats,
					`last_updated` = :last_updated
				WHERE `user_id` = :user_id 
					AND `character_id` = :character_id";

			$stmt = $this->PDO->prepare($update);

			$stmt->execute( 
				array(
					'character_name' => $data['character']['name'],
					'character_mutant_name' => $data['character']['mutant_name'],
					'character_power_type' => $data['character']['power_type'],
					'character_xp' => $data['character']['xp'],
					'character_stats' => json_encode($data['stats']),
					'last_updated' => date('Y-m-d H:i:s'),
					'user_id' => $data['user_id'],
					'character_id' => $data['character_id'],
					
				)
			);

			return $stmt->rowCount();
		}catch(PDOException $e){
			//error_log($e->getMessage(), 0);
		}

		return false;
	}

	/**
	 * After updating character powers, tell the character to update itself
	 * 
	 * $CHARACTER->powers[] = array() / new Power;
	 * $CHARACTER->updatePowers();
	 */
	function updatePowers(){
		try{
			$update = 
			"UPDATE `characters`   
				SET `character_powers` = :character_powers,
					`last_updated` = :last_updated
				WHERE `user_id` = :user_id 
					AND `character_id` = :character_id";

			$stmt = $this->PDO->prepare($update);

			$stmt->execute( 
				array(
					'character_powers' => json_encode($this->powers),
					'last_updated' => date('Y-m-d H:i:s'),
					'user_id' => $this->user_id,
					'character_id' => $this->character_id,
					
				)
			);

			return $stmt->rowCount();
		}catch(PDOException $e){
			//error_log($e->getMessage(), 0);
		}
		
		return false;
	}

	/**
	 * After updating character powers, tell the character to update itself
	 * 
	 * $CHARACTER->equipment[] = array() / new Power;
	 * $CHARACTER->updateEquipment();
	 */
	function updateEquipment(){
		try{
			$update = 
			"UPDATE `characters` 
				SET `character_equipment` = :character_equipment,
					`last_updated` = :last_updated
				WHERE `user_id` = :user_id 
					AND `character_id` = :character_id";

			$stmt = $this->PDO->prepare($update);

			$stmt->execute( 
				array(
					'character_equipment' => json_encode($this->equipment),
					'last_updated' => date('Y-m-d H:i:s'),
					'user_id' => $this->user_id,
					'character_id' => $this->character_id,
					
				)
			);

			return $stmt->rowCount();
		}catch(PDOException $e){
			//error_log($e->getMessage(), 0);
		}
		
		return false;
		
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

	function disabled(){
		return $this->view?'disabled readonly':'';
	}

	/**
	 * Display the Name and XP
	 * 
	 */
	function displayNames(){
		$display_names = array(
			'name' => 'Character Name',
			'mutant_name' => 'Mutant Name',
			'power_type' => 'Power Type',
			'xp' => 'Total XP',
		); ?>
		<div class="wrapper">
			<div class="container">
				<div class="row">

		<?php foreach($display_names as $prop => $display_name){
			echo '<div class="col-12 col-sm-6">
					<div class="form-group">
						<label for="character_'.$prop.'">'.$display_name.'</label>
						<input type="text" class="form-control character-save" id="character_'.$prop.'" name="character['.$prop.']" value="'.$this->getProp($prop).'" '.$this->disabled().'>
					</div>
				</div>';
				
			}
		?>

				</div>
			</div>
		</div>
		<?php 
	}


	/**
	 * Display the Vitals, Stats, and Skills
	 */
	function displayStats(){
		$display_stats = array(
			'vitals',
			'stats',
			'skills'
		);

		foreach($display_stats as $display_stat): ?>
			<div class="wrapper">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h2 class="text-center"><?php echo ucwords($display_stat); ?></h2>
						</div>
					</div>
					<div class="row">
						<?php 
							foreach($this->{$display_stat} as $type => $stat){
								echo '<div class="col-4">';

								foreach($stat as $prop => $name){
									//does this element need increment buttons?
									$increment = $display_stat == 'vitals' && 'physical' == $type?true:false;
									$roll = $display_stat != 'vitals'?true:false;

									$this->displayStat($name, $prop, $roll, $increment);
								}
								
								echo '</div>';
							}
						?>
					</div>
				</div>
			</div>
		<?php endforeach;
	}


	/**
	 * Display the a stat / skill component
	 * 
	 * @param string $name The name of the stat or skill
	 * @param int $value The value of this stat or skill
	 */
	function displayStat($name, $prop, $roll = true, $increment = false){
		$id = $prop;
		$value = $this->getProp($prop);
	
		echo '<div class="form-group">
				<label for="'.$id.'">'.ucwords($name).'</label>
				<div class="input-group">';
		
		//&& ! $roll
		if(! $this->view && $increment){
			echo '<div class="input-group-prepend d-print-none">
					<span class="input-group-text increment" data-target="'.$id.'">
						<i class="far fa-chevron-up"></i>
					</span>
				</div>';
		}
	
		echo '	<input type="number" class="form-control number-control character-save" id="'.$id.'" name="stats['.$id.']" value="'.(empty($value)?0:$value).'" aria-describedby="'.$id.'-label" pattern="[0-9]{3}" min="0" max="999" maxlength="3" '.$this->disabled().'>
				<div class="input-group-append d-print-none">';
		
		if($roll){
			//echo '<span class="input-group-text roller"><i class="far fa-dice-d20"></i></span>';
		}else if(! $this->view && $increment){
			echo '<span class="input-group-text decrement" data-target="'.$id.'"><i class="far fa-chevron-down"></i></span>';
		}
		
		echo '		</div>
				</div>
			</div>';
		
	}

	/**
	 * List the vitals, stats, skills without their categories as an options list
	 * 
	 * @param string $stat vitals, stats, skills
	 */
	function optionStat($stat){
		foreach($this->{$stat} as $type => $values){
			foreach($values as $prop => $name){
				echo '<option value="'.$name.'">'.$name.'</option>';
			}
		}
	}


	/**
	 * Display the Powers in the Power Table
	 */
	function displayPowers(){

		?>
		<div id="powers" class="col-12 col-md-6">
			<h2 class="text-center">Powers</h2>

			<table id="power-table" class="table">
				<thead>
					<tr>
						<th>Type</th>
						<th>Name</th>
						<th>Damage</th>
						<th>Effect</th>
						<!-- <th class="text-center no-print">Roll</th> -->
						<!-- <th class="text-center no-print">Mutate</th> -->
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach($this->powers as $key => $power) {
						$power['object'] = htmlspecialchars(json_encode($power), ENT_QUOTES, 'UTF-8');
						$this->displayPower($key, $power);
					}
				?>
				</tbody>
			</table>

			<?php if(! $this->view): ?>
				<button id="add-power" class="btn btn-default no-print w-100"><i class="far fa-plus-circle"></i> Add Power</button>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Display A Single power
	 */
	function displayPower($key, $power){
		//<td class="dice roller"><i class="far fa-dice-d20"></i></td>
		//<td class="dice mutate"><i class="far fa-atom"></i></td>

		echo '<tr id="power-'.$key.'" class="edit-power pointer" data-key="'.$key.'" data-object=\''.$power['object'].'\'>
				<th class="type">'.(!$this->view?'<i class="far fa-fw fa-info-circle no-print"></i> ':'').'<span>'.$power['type'].'</span></th>
				<td class="name">'.$power['name'].'</td>
				<td class="damage">'.$power['damage'].'</td>
				<td class="effect">'.$power['effect'].'</td>
			</tr>';
	}

	/**
	 * Display Equipment
	 */
	function displayEquipment(){
		?>
		<div id="equipment" class="col-12 col-md-6">
			<h2 class="text-center">Equipment</h2>

			<table id="equipment-table" class="table equipment-table">
				<thead>
					<tr>
						<th>Slot</th>
						<th>Name</th>
						<th>Bonus</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach($this->equipment as $key => $item){
						$item['object'] = htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8');
						$this->displayItem($key, $item);
					}
				?>
				</tbody>
			</table>

			<?php if(! $this->view): ?>
				<button id="add-equipment" class="btn btn-default no-print w-100"><i class="far fa-plus-circle"></i> Add Equipment</button>
			<?php endif; ?>
			
		</div>
		<?php 
	}

	/**
	 * Display a single equipment element
	 */
	function displayItem($key, $item){
		echo '<tr id="equipment-'.$key.'" class="edit-equipment pointer"  data-key="'.$key.'" data-bonus="'.$item['bonus'].'" data-stat="'.$item['stat'].'" data-object=\''.$item['object'].'\'">
				<th class="slot">'.(!$this->view?'<i class="far fa-fw fa-info-circle no-print"></i> ':'').'<span>'.ucwords($item['slot']).'</span></th>
				<td class="name">'.$item['name'].'</td>
				<td class="bonus" data-bonus="'.$item['bonus'].'" data-stat="'.$item['stat'].'">+'.$item['bonus'].' '.ucwords($item['stat']).'</td>
			</tr>';
	}

	/**
	 * Display a styled select option with an array.
	 * 
	 * @param array $array Array to display in the select statement
	 * @param string $id The CSS ID for this element
	 * @param string $name The HTML name for this element
	 * @param string $classes The CSS Classes for this element
	 * @param array $assc Is this an associated array?
	 */
	function displaySelect($array, $id = '', $name = '', $classes = '', $assc = false){
		echo '<div class="mad-style '.($this->view?'disabled':'').'">
			<select id="'.$id.'" name="'.$name.'" class="'.$classes.'" '.$this->disabled().'>';
			
		// TODO: May want to actually setup a key for these values so we are not referencing strings?
		foreach($this->{$array} as $key => $value){
			echo '<option value="'.($assc?$key:$value).'">'.$value.'</option>';
		}
		echo '</select>
		</div>';

	}

}