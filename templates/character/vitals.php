<?php 
	$vitals = array();
	$vitals['physical'] = array(
		'health' => 20,
		'power' => 0
	);

	$vitals['mental'] = array(
		'health_regen' => 0,
		'power_regen' => 0
	);

	$vitals['personality'] = array(
		'armor' => 0,
		'resistance' => 0
	);
?>
<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Vitals</h2>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach($vitals as $type => $vital){
					echo '<div class="col-4">';

					foreach($vital as $stat => $value){
						if($type == 'physical'){
							$increment = true;
						}else{
							$increment = false;
						}
						jb_display_number_group($stat, $CHARACTER['character_vitals'][$stat], false, $increment);
					}
					
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>