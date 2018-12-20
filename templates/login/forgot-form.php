<form action="" method="post" id="forgot-form" class="login-form">
	<h5>Forgot Password</h5>

	<?php require_once('alert.php'); ?>
	<?php require_once('success.php'); ?>

	<div class="form-group">
		<input type="email" class="form-control" id="forgot-email" name="email" placeholder="Email" required>
	</div>
	<button type="submit" class="btn btn-primary">Get New Password</button>
	<a href="#" class="btn btn-default float-right signin-btn">Sign In</a>
</form>