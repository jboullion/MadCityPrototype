<?php 
	$vitals = array();
	$vitals['physical'] = array(
		'health' => 20,
		'power' => 0
	);

	$vitals['mental'] = array(
		'health regen' => 0,
		'power regen' => 0
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
				foreach($vitals as $name => $vital){
					echo '<div class="col-4">'; //<h5>'.ucwords($name).'</h5>

					foreach($vital as $name => $value){
						jb_display_number_group($name, $value, false);
					}
					
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>