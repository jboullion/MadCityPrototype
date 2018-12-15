<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="character-name">Character Name</label>
					<input type="text" class="form-control" id="character-name" value="<?php echo $CHARACTER->getProp('name'); ?>">
				</div>
			</div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="mutant-name">Mutant Name</label>
					<input type="text" class="form-control" id="mutant-name" value="<?php echo $CHARACTER->getProp('mutant_name'); ?>">
				</div>
			</div>
			
			<div class="col-6">
				<div class="form-group">
					<label for="power-type">Power Type</label>
					<input type="text" class="form-control" id="power-type" value="<?php echo $CHARACTER->getProp('power_type'); ?>">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group">
					<label for="total-xp">Total XP</label>
					<input type="number" class="form-control" id="total-xp" value="<?php echo $CHARACTER->getProp('xp'); ?>">
				</div>
			</div>
		</div>
	</div>
</div>
