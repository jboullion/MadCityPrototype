<?php 
	$powers = array();

	$powers[] = array(
		'set' => 'Special Ability',
		'name' => 'Telepathy',
		'description' => 'Read Minds. 14: Emotions, 18: Intentions, 20: Thoughts',
		'damage' => false,
		'stat' => WILL, // Need to set this to the value of the users stat
		'burn' => true
	);

	$powers[] = array(
		'set' => 'Direct Damage',
		'name' => 'Psychic Blast',
		'description' => '1d4 to a single target',
		'damage' => 4,
		'stat' => WILL
	);

	$powers[] = array(
		'set' => 'Status',
		'name' => 'Psychic Blast',
		'description' => '1d4 per point to a single target',
		'damage' => 4,
		'stat' => WILL // Need to set this to the value of the users stat
	);

	$powers[] = array(
		'set' => 'Condition',
		'name' => 'Psychic Blast',
		'description' => '1d4 per point to a single target',
		'damage' => 4,
		'stat' => WILL // Need to set this to the value of the users stat
	);

	/**
	 * A Heroes power.
	 */
	class Power { 
		var $name; 
		var $description;
		var $damage; // the "d" value of the dice involved
		var $act;
		VAR $stat;

		/**
		 * @param string $name The name of the power
		 * @param string $description The name of the power
		 * @param int $damage The random value to determine damage
		 * @param int $act The Act the power belongs in
		 * @param bool $burn Can this power burn power points
		 */
		function __construct($name, $description, $damage, $act, $stat) {
			$this->name = $name;
			$this->$description = $description;
			$this->$damage = $damage; // the "d" value of the dice involved
			$this->$act = $act;
			$this->$stat = $stat;
		}

		/**
		 * Roll this power
		 * 
		 * @param int $attack 
		 */
		function roll($attack = 0, $stat = 0, $items = 0){
			return rand(1,20) + $stat + $items;
		}

	}
?>
<div id="powers" class="col-12 col-md-6">
	<h2 class="text-center">Powers</h2>
	<div class="power-wrapper">

		<table class="table power-table">
		<?php 
			foreach($powers as $power){
				

				// <h6 class="card-subtitle mb-2 text-muted">'.$mutation['damage'].'</h6>
				echo '<tr data-damage="'.$power['damage'].'">
						<th class="set">'.$power['set'].'</th>
						<td class="name">'.$power['name'].'</td>
						<td class="dice roller"><i class="fal fa-dice-d20"></i></td>
						<td class="dice mutate"><i class="fal fa-atom"></i></td>
					</tr>';

				
			}
		?>
		</table>
	</div>
</div>