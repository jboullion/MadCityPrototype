<?php 
	$skills = $CHARACTER['skills'];
?>
<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">Skills</h2>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach($skills as $name => $skill){
					echo '<div class="col-4">'; //<h5>'.ucwords($name).'</h5>

					foreach($skill as $name => $value){
						jb_display_number_group($name, $value);
					}
					
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>