<?php 
	//$equipment = $CHARACTER['equipment'];
	
	$slots = array();

	/*
	$slots = array(
		'head',
		'torso',
		'hands',
		'legs',
		'feet',
		'accessory'
	);
	*/
?>
<div id="equipment" class="col-12 col-md-6">
	<h2 class="text-center">Equipment</h2>

	<table class="table equipment-table">
		<thead>
			<tr>
				<th>Slot</th>
				<th>Name</th>
				<th>Bonus</th>
			</tr>
		</thead>
		<tr>
			<th class="slot"><i class="fal fa-fw fa-info-circle info no-print"></i> Head</th>
			<td class="name">Amplifier</td>
			<td class="bonus" data-bonus="1" data-stat="9">+1 Will</td>
		</tr>
	<?php 
		foreach($slots as $slot){
			echo '<tr>
					<th class="slot"><i class="fal fa-fw fa-info-circle info no-print"></i> Head</th>
					<td class="name">Amplifier</td>
					<td class="bonus" data-bonus="1" data-stat="9">+1 Will</td>
				</tr>';
		}
	?>
	</table>

	<button id="add-equipment" class="btn btn-default no-print"><i class="fal fa-plus-circle"></i> Add Equipment</button>
</div>
