<?php 
	$powers = array();

	//$powers[0] = new Power('Psychic Blast', '1d4 per point to a single target', 4, 1, true);

	/*
	2 => array(
		'name' => 'Psychic Blast 2',
		'description' => '1d8 per point to a single target',
		'damage' => 8,
		'burn' => true
	),
	3 => array(
		'name' => 'Psychic Blast 3',
		'description' => '1d12 per point to a single target',
		'damage' => 12,
		'burn' => true
	),
	4 => array(
		'name' => 'Psychic Blast 4',
		'description' => '1d12 and 1d4 per point to a single target',
		'damage' => 16,
		'burn' => true
	),
	5 => array(
		'name' => 'Psychic Blast 5',
		'description' => '2d10 or 1d20 per point to a single target',
		'damage' => 20,
		'burn' => true
	)
	*/
	$powers[] = array(
		'set' => 'Special Ability',
		'mutations' => array(
					1 => array(
						'name' => 'Psychic Blast',
						'description' => '1d4 per point to a single target',
						'damage' => 4,
						'burn' => true
					),
					2 => array(
						'name' => 'Psychic Blast 2',
						'description' => '1d8 per point to a single target',
						'damage' => 8,
						'burn' => true
					),
					3 => array(
						'name' => 'Psychic Blast 3',
						'description' => '1d12 per point to a single target',
						'damage' => 12,
						'burn' => true
					),
					4 => array(
						'name' => 'Psychic Blast 4',
						'description' => '1d12 and 1d4 per point to a single target',
						'damage' => 16,
						'burn' => true
					),
					5 => array(
						'name' => 'Psychic Blast 5',
						'description' => '2d10 or 1d20 per point to a single target',
						'damage' => 20,
						'burn' => true
					)
				)
	);

	$powers[] = array(
		'set' => 'Direct Damage',
		'mutations' => array(
					1 => array(
						'name' => 'Psychic Blast',
						'description' => '1d4 per point to a single target',
						'damage' => 4,
						'burn' => true
					),
					2 => array(
						'name' => 'Psychic Blast 2',
						'description' => '1d8 per point to a single target',
						'damage' => 8,
						'burn' => true
					),
					3 => array(
						'name' => 'Psychic Blast 3',
						'description' => '1d12 per point to a single target',
						'damage' => 12,
						'burn' => true
					),
					4 => array(
						'name' => 'Psychic Blast 4',
						'description' => '1d12 and 1d4 per point to a single target',
						'damage' => 16,
						'burn' => true
					),
					5 => array(
						'name' => 'Psychic Blast 5',
						'description' => '2d10 or 1d20 per point to a single target',
						'damage' => 20,
						'burn' => true
					)
				)

	);

	$powers[] = array(
		'set' => 'Status',
		'mutations' => array(
					1 => array(
						'name' => 'Psychic Blast',
						'description' => '1d4 per point to a single target',
						'damage' => 4,
						'burn' => true
					),
					2 => array(
						'name' => 'Psychic Blast 2',
						'description' => '1d8 per point to a single target',
						'damage' => 8,
						'burn' => true
					),
					3 => array(
						'name' => 'Psychic Blast 3',
						'description' => '1d12 per point to a single target',
						'damage' => 12,
						'burn' => true
					),
					4 => array(
						'name' => 'Psychic Blast 4',
						'description' => '1d12 and 1d4 per point to a single target',
						'damage' => 16,
						'burn' => true
					),
					5 => array(
						'name' => 'Psychic Blast 5',
						'description' => '2d10 or 1d20 per point to a single target',
						'damage' => 20,
						'burn' => true
					)
				)

	);

	$powers[] = array(
		'set' => 'Condition',
		'mutations' => array(
					1 => array(
						'name' => 'Psychic Blast',
						'description' => '1d4 per point to a single target',
						'damage' => 4,
						'burn' => true
					),
					2 => array(
						'name' => 'Psychic Blast 2',
						'description' => '1d8 per point to a single target',
						'damage' => 8,
						'burn' => true
					),
					3 => array(
						'name' => 'Psychic Blast 3',
						'description' => '1d12 per point to a single target',
						'damage' => 12,
						'burn' => true
					),
					4 => array(
						'name' => 'Psychic Blast 4',
						'description' => '1d12 and 1d4 per point to a single target',
						'damage' => 16,
						'burn' => true
					),
					5 => array(
						'name' => 'Psychic Blast 5',
						'description' => '2d10 or 1d20 per point to a single target',
						'damage' => 20,
						'burn' => true
					)
				)

	);

	/**
	 * A Heroes power.
	 */
	class Power { 
		var $name; 
		var $description;
		var $damage; // the "d" value of the dice involved
		var $act;
		var $burn; // Can this power expend more than one PP?

		/**
		 * @param string $name The name of the power
		 * @param string $description The name of the power
		 * @param int $damage The random value to determine damage
		 * @param int $act The Act the power belongs in
		 * @param bool $burn Can this power burn power points
		 */
		function __construct($name, $description, $damage, $act, $burn) {
			$this->name = $name; 
			$this->$description = $description; 
			$this->$damage = $damage;  // the "d" value of the dice involved
			$this->$act = $act; 
			$this->$burn = $burn;  // Can this power expend more than one PP?
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
<section class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Powers</h2>
			</div>
		</div>
		<div class="row">
		<?php 
			foreach($powers as $power){
				echo '<div class="col-12 col-sm-6 col-lg-3 power-wrapper">';

				echo '<h5>'.$power['set'].'</h5>';

				echo '<table class="table power-table">';
				// <h6 class="card-subtitle mb-2 text-muted">'.$mutation['damage'].'</h6>
				if(! empty($power['mutations'])){
					foreach($power['mutations'] as $mutation){

						echo '<tr data-burn="'.$mutation['burn'].'">
								<td>'.$mutation['name'].'</td>
								<td class="dice"><i class="fal fa-dice-d20"></i></td>
								<td class="dice"><i class="fas fa-fw fa-plus-square"></i></td>
								<td class="dice"><i class="fal fa-atom"></i></td>
							</tr>';

						/*
						echo '<div class="card" data-burn="'.$mutation['burn'].'" >
								<div class="card-body">
								
									<p class="card-title font-weight-bold">
									
									 '.$mutation['name'].'</p>
									<button class="btn btn-primary">Roll</button>
									<button class="btn btn-danger">Burn</button>
									<button class="btn btn-success">Mutate</button>
								</div>
							</div>';
						
							break;
						*/
					}
				}
				echo '</table>';

				echo '</div>';
			}
		?>
		</div>
	</div>
</section>
<script>
	jQuery(function () {
		$('[data-toggle="tooltip"]').tooltip({
			trigger: 'click'
		});
	})
</script>
