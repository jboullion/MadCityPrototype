<?php 
	$stats = array();
	$stats['physical'] = array(
		'strength' => 0,
		'dexterity' => 0,
		'stamina' => 0
	);

	$stats['mental'] = array(
		'intelligence' => 0,
		'perception' => 0,
		'wisdom' => 0
	);

	$stats['personality'] = array(
		'charisma' => 0,
		'rage' => 0,
		'will' => 0
	);
?>
<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Stats</h2>
			</div>
		</div>
		<div class="row">
		<?php 
			foreach($stats as $name => $stat){
				echo '<div class="col-4">'; //<h5>'.ucwords($name).'</h5>

				foreach($stat as $name => $value){
					jb_display_number_group($name, $value);
				}
				
				echo '</div>';
			}
		?>
		</div>
	</div>
</div>