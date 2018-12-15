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

	// dynamic sets 
	var $powers;
	var $equipment;

	/**
	 * @param array $character The results of a 
	 */
	function __construct($PDO, $character_id, $user_id) {
		$this->PDO = $PDO;

		$this->character_id = $character_id;
		$this->user_id = $user_id;

		$stmt = $this->PDO->prepare("SELECT * FROM characters WHERE character_id = :character_id AND user_id = :user_id LIMIT 1");
		$stmt->execute( array('character_id' => $character_id, 'user_id' => $user_id) );
		$data = $stmt->fetch();

		$this->name = $data['character_name'];
		$this->mutant_name = $data['character_mutant_name'];
		$this->power_type = $data['character_power_type'];
		$this->xp = $data['character_xp'];

		$character_data = json_decode($data['character_data'], true);

		//dynamically assign our values...clever or dangerous?...BOTH! ;)
		foreach($character_data as $key => $value){
			$this->{$key} = $value;
		}

	}


	/**
	 * Take the data submitted from the form
	 * 
	 * @param array $data The character form data
	 */
	function update($data){
		$update = 
		"UPDATE `characters`   
			SET `character_name` = :character_name,
				`character_mutant_name` = :character_mutant_name,
				`character_power_type` = :character_power_type,
				`character_xp` = :character_xp,
				`character_data` = :character_data,
				`last_updated` = :last_updated
			WHERE `user_id` = :user_id AND `character_id` = :character_id";


		$stmt = $this->PDO->prepare($update);

		$stmt->execute( 
			array(
				'character_name' => $data['character']['name'],
				'character_mutant_name' => $data['character']['mutant_name'],
				'character_power_type' => $data['character']['power_type'],
				'character_xp' => $data['character']['xp'],
				'character_data' => json_encode($data['data']),
				'last_updated' => date('Y-m-d H:i:s'),
				'user_id' => $data['user_id'],
				'character_id' => $data['character_id'],
				
			)
		);

		return $stmt->rowCount();
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

		<?php foreach($display_names as $prop => $display_name): ?>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="character_<?php echo $prop; ?>"><?php echo $display_name; ?></label>
					<input type="text" class="form-control character-save" id="character_<?php echo $prop; ?>" name="character[<?php echo $prop; ?>]" value="<?php echo $this->getProp($prop); ?>">
				</div>
			</div>
		<?php endforeach; ?>

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
							foreach($this->{$display_stat} as $type => $vital){
								echo '<div class="col-4">';

								foreach($vital as $prop => $name){
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
		
		if(! $roll && $increment){
			echo '<div class="input-group-prepend d-print-none">
					<span class="input-group-text increment" data-target="'.$id.'">
						<i class="fal fa-chevron-square-up"></i>
					</span>
				</div>';
		}
	
		echo '	<input type="number" class="form-control number-control character-save" id="'.$id.'" name="data['.$id.']" value="'.$value.'" aria-describedby="'.$id.'-label" pattern="[0-9]{3}" min="0" max="999" maxlength="3">
				<div class="input-group-append d-print-none">';
		
		if($roll){
			echo '<span class="input-group-text roller"><i class="fal fa-dice-d20"></i></span>';
		}else if($increment){
			echo '<span class="input-group-text decrement" data-target="'.$id.'"><i class="fal fa-chevron-square-down"></i></span>';
		}
		
		echo '		</div>
				</div>
			</div>';
		
	}

}