<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="character-name">Character Name</label>
					<input type="text" class="form-control" id="character-name" value="<?php echo $CHARACTER['character_name'] ?>">
				</div>
			</div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="hero-name">Hero Name</label>
					<input type="text" class="form-control" id="hero-name" value="<?php echo $CHARACTER['character_hero_name'] ?>">
				</div>
			</div>
			
			<div class="col-6">
				<div class="form-group">
					<label for="power-type">Power Type</label>
					<input type="text" class="form-control" id="power-type" value="<?php echo $CHARACTER['character_type'] ?>">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group">
					<label for="total-xp">Total XP</label>
					<input type="number" class="form-control" id="total-xp" value="<?php echo $CHARACTER['character_xp'] ?>">
				</div>
			</div>
		</div>
	</div>
</div>
