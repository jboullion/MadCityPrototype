<?php 
	//$powers = $CHARACTER['powers'];
	$powers[0] = array(
		'name' => 'Psychic Blast',
		'damage' => 4,
		'type' => 'Psychic',
		'description' => '',
		'level' => 0
	);
?>
<div id="powers" class="col-12 col-md-6">
	<h2 class="text-center">Powers</h2>

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

			// <i class="far fa-fw fa-info-circle info no-print"></i> '.$power['type'].'

			// <td class="dice roller"><i class="far fa-dice-d20"></i></td>
			// <td class="dice mutate"><i class="far fa-atom"></i></td>

			echo '<tr data-damage="">
					<th class="type"><i class="far fa-fw fa-info-circle info no-print"></i> '.$power['type'].'</th>
					<td class="name">'.$power['name'].'</td>
					<td class="dice roller"><i class="far fa-dice-d20"></i></td>
					<td class="dice mutate"><i class="far fa-atom"></i></td>
				</tr>';
		}
	?>
	</table>

	<button id="add-power" class="btn btn-default no-print w-100"><i class="far fa-plus-circle"></i> Add Power</button>
</div>