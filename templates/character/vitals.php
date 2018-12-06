<?php 
	$vitals = array();
	$vitals['physical'] = array(
		'melee' => 0,
		'athletics' => 0,
		'drive' => 0,
		'fire arms' => 0,
	);

	$vitals['mental'] = array(
		'investigate' => 0,
		'medicine' => 0,
		'computers' => 0,
		'science' => 0,
	);

	$vitals['personality'] = array(
		'stealth' => 0,
		'persuasion' => 0,
		'empathy' => 0,
		'alertness' => 0,
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
				foreach($vitals as $name => $vital){
					echo '<div class="col-12 col-md-4">
							<h5>'.ucwords($name).'</h5>';

					foreach($vital as $name => $value){
						jb_display_number_group($name, $value);
					}
					
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>