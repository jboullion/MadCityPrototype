<?php 
	$equipment = array(
		'head' => array(
			'name' => 'Baseball Cap',
			'description' => '',
			'bonus' => 1,
			'stat' => 1
		),
		'torso' => array(
			'name' => 'Hockey Pads',
			'description' => '',
			'bonus' => 1,
			'stat' => 2
		),
		'gloves' => array(
			'name' => 'Batting Gloves',
			'description' => '',
			'bonus' => 1,
			'stat' => 3
		),
		'legs' => array(
			'name' => 'Skin Tight Kevlar',
			'description' => '',
			'bonus' => 1,
			'stat' => 4
		),
		'feet' => array(
			'name' => 'Super Sneakers',
			'description' => '',
			'bonus' => 1,
			'stat' => 5
		),
		'accessory' => array(
			'name' => 'Necklace of Mojo',
			'description' => 'Yeah Baby',
			'bonus' => 1,
			'stat' => 6
		)
	);

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
	<?php 
		foreach($equipment as $slot => $item){

			echo '<tr>
					<th class="slot"><i class="fal fa-fw fa-info-circle info no-print"></i> '.ucwords($slot).'</th>
					<td class="name">'.$item['name'].'</td>
					<td class="bonus" data-bonus="'.$item['bonus'].'" data-stat="'.$item['stat'].'">+'.$item['bonus'].' '.$STATS[$item['stat']].'</td>
				</tr>';

		}
	?>
	</table>
</div>
