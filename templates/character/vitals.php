<?php 
	$vitals = $CHARACTER['vitals'];
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
						jb_display_number_group($stat, $value, false, $increment);
					}
					
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>