<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="hero-name">Hero Name</label>
					<input type="text" class="form-control" id="hero-name">
				</div>
				<div class="form-group">
					<label for="player-name">Player Name</label>
					<input type="text" class="form-control" id="player-name">
				</div>
			</div>
			<div class="col-12 col-sm-6">
				<div class="form-group">
					<label for="power-type">Power Type</label>
					<input type="text" class="form-control" id="power-type">
				</div>
				<div class="form-group">
					<label for="total-exp">Total Exp</label>
					<input type="number" class="form-control" id="total-exp">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4">
				<div class="form-group">
					<label>Max HP <span id="max-health">20</span></label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="health-label">Health</span>
						</div>
						<input type="number" class="form-control number-control" id="health" aria-describedby="health-label" pattern="[0-9]{3}" min="0" max="999" maxlength="3">
					</div>
				</div>
				<div class="form-group">
					<label>Max Power <span id="max-power">1</span></label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="power-label">Power</span>
						</div>
						<input type="number" class="form-control number-control" id="power" aria-describedby="power-label" pattern="[0-9]{2}" min="0" max="10" maxlength="2">
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4">
				<div class="form-group">
					<label>&nbsp;</label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="health-regen-label">Health Regen</span>
						</div>
						<input type="number" class="form-control number-control" id="health-regen" aria-describedby="health-regen-label" pattern="\d{2}" min="0" max="10" maxlength="2">
					</div>
				</div>
				<div class="form-group">
					<label>&nbsp;</label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="power-regen-label">Power Regen</span>
						</div>
						<input type="number" class="form-control number-control" id="power-regen" aria-describedby="power-regen-label" pattern="\d{2}" min="0" max="10" maxlength="2">
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4">
				<div class="form-group">
					<label>&nbsp;</label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="armor-label">Armor</span>
						</div>
						<input type="number" class="form-control number-control" id="armor" aria-describedby="armor-label" pattern="[0-9]{2}" min="0" max="10" maxlength="2">
					</div>
				</div>
				<div class="form-group">
					<label>&nbsp;</label>
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text" id="resistance-label">Resistance</span>
						</div>
						<input type="number" class="form-control number-control" id="resistance" aria-describedby="resistance-label" pattern="[0-9]{2}" min="0" max="10" maxlength="2">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>