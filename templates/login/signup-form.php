<form action="" method="post" id="signup-form" class="login-form">
	<h5>Sign Up</h5>

	<?php require_once('alert.php'); ?>

	<div class="form-group">
		<input type="text" class="form-control" id="signup-username" name="username" aria-describedby="usernameHelp" placeholder="Username" required>
	</div>
	<div class="form-group">
		<input type="email" class="form-control" id="signup-email" name="email" aria-describedby="emailHelp" placeholder="Email" required>
		<small class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<input type="password" class="form-control" id="signup-password" name="password" placeholder="Password" required>
	</div>
	<button type="submit" class="btn btn-primary">Sign Up</button>	
	<a href="#" class="btn btn-default float-right signin-btn">Sign In</a>
</form>