<?php 
	$powers = array();

	$powers[] = array(
		'set' => 'Special Ability',
		'name' => 'Telepathy',
		'description' => 'Read Minds. 14: Emotions, 18: Intentions, 20: Thoughts',
		'damage' => false,
		'stat' => 9, 
		'burn' => true
	);

	$powers[] = array(
		'set' => 'Direct Damage',
		'name' => 'Psychic Blast',
		'description' => '1d4 to a single target',
		'damage' => 4,
		'stat' => 9
	);

	$powers[] = array(
		'set' => 'Status',
		'name' => 'Psychic Blast',
		'description' => '1d4 per point to a single target',
		'damage' => 4,
		'stat' => 9
	);

	$powers[] = array(
		'set' => 'Condition',
		'name' => 'Psychic Blast',
		'description' => '1d4 per point to a single target',
		'damage' => 4,
		'stat' => 9 
	);

	
?>
<div id="powers" class="col-12 col-md-6">
	<h2 class="text-center">Powers</h2>
	<div class="power-wrapper">

		<table class="table power-table">
			<thead>
				<tr>
					<th>Type</th>
					<th>Name</th>
					<th class="text-center no-print">Roll</th>
					<th class="text-center no-print">Mutate</th>
				</tr>
			</thead>
		<?php 
			foreach($powers as $power){
				

				// <h6 class="card-subtitle mb-2 text-muted">'.$mutation['damage'].'</h6>
				echo '<tr data-damage="'.$power['damage'].'">
						<th class="set"><i class="fal fa-fw fa-info-circle info no-print"></i> '.$power['set'].'</th>
						<td class="name">'.$power['name'].'</td>
						<td class="dice roller"><i class="fal fa-dice-d20"></i></td>
						<td class="dice mutate"><i class="fal fa-atom"></i></td>
					</tr>';

				
			}
		?>
		</table>
	</div>
</div>