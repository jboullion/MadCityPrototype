<?php 

?>
<div id="mutate-modal" class="action-modal">
	<div id="mutate" class="action-content">
		<div class="action-title">
			Mutate
			<i class="fal fa-times-circle action-close"></i>
		</div>
		<div class="action-body">
			<h6>Please select a mutation:</h6>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
				<label class="form-check-label" for="exampleRadios1">
					Damage: +1d4
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
				<label class="form-check-label" for="exampleRadios2">
					Condition: Choose Mental Condition
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
				<label class="form-check-label" for="exampleRadios3">
					DoT: 1 Damage / round for 1d6 rounds
				</label>
			</div>
		</div>
		<div class="action-footer">
			<!--  <button type="button" class="btn btn-outline-danger action-close">Cancel</button> -->
			<button type="button" class="btn btn-outline-success">Mutate</button>
		</div>
	</div>
</div>