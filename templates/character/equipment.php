<?php 
	$equipment = array(
		'head' => array(
			'name' => 'Baseball Cap',
			'description' => '',
			'bonus' => 1,
			'stat' => PERCEPTION
		),
		'torso' => array(
			'name' => 'Hockey Pads',
			'description' => '',
			'bonus' => 1,
			'stat' => ARMOR
		),
		'gloves' => array(
			'name' => 'Batting Gloves',
			'description' => '',
			'bonus' => 1,
			'stat' => MELEE
		),
		'legs' => array(
			'name' => 'Skin Tight Kevlar',
			'description' => '',
			'bonus' => 1,
			'stat' => ARMOR
		),
		'feet' => array(
			'name' => 'Super Sneakers',
			'description' => '',
			'bonus' => 1,
			'stat' => INITIATIVE
		),
		'accessory' => array(
			'name' => 'Necklace of Mojo',
			'description' => 'Yeah Baby',
			'bonus' => 1,
			'stat' => CHARISMA
		)
	);

	/**
	 * A Heroes power.
	 */
	class Equipment { 
		var $name; 
		var $description;
		var $damage; // the "d" value of the dice involved
		var $act;
		VAR $ammo;

		/**
		 * @param string $name The name of the power
		 * @param string $description The name of the power
		 * @param int $damage The random value to determine damage
		 * @param int $act The Act the power belongs in
		 * @param bool $burn Can this power burn power points
		 */
		function __construct($name, $description, $damage, $act, $ammo) {
			$this->name = $name;
			$this->$description = $description;
			$this->$damage = $damage; // the "d" value of the dice involved
			$this->$act = $act;
			$this->$ammo = $ammo;
			$this->notes = $notes;
		}

		function getDamage(){
			return $this->$damage;
		}

		function setDamage($damage){
			$this->$damage = $damage;
		}

		function getAmmo(){
			return $this->$ammo;
		}

		function setAmmo($ammo){
			$this->$ammo = $ammo;
		}

		function getNotes(){
			return $this->$notes;
		}

		function setNotes($notes){
			$this->$notes = $notes;
		}

	}
?>
<div id="equipment" class="col-12 col-md-6">
	<h2 class="text-center">Equipment</h2>

	<table class="table equipment-table">
	<?php 
		foreach($equipment as $slot => $item){

			echo '<tr>
					<th class="slot"><i class="fal fa-fw fa-info-circle info"></i> '.ucwords($slot).'</th>
					<td class="name">'.$item['name'].'</td>
				</tr>';

		}
	?>
	</table>
</div>
