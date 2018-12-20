<form action="" method="post" id="signin-form" class="login-form open">
	<div class="g-signin2 float-right" data-onsuccess="googleSignIn"></div>
	<h5>Sign In</h5>
	
	<?php require_once('alert.php'); ?>

	<div class="form-group">
		<!-- <label for="exampleInputEmail1">Email address</label> -->
		<input type="email" class="form-control" id="signin-email" name="email" placeholder="Email" required>
	</div>
	<div class="form-group">
		<!-- <label for="exampleInputPassword1">Password</label> -->
		<input type="password" class="form-control" id="signin-password" name="password" placeholder="Password" required>
	</div>
	<!-- 
		<div class="form-group form-check">
			<input type="checkbox" class="form-check-input" id="exampleCheck1">
			<label class="form-check-label" for="exampleCheck1">Remember Me</label>
		</div>
	-->
	<button type="submit" class="btn btn-primary">Sign In</button>

	<a href="#" class="btn btn-default float-right signup-btn">Sign Up</a>

	<div class="clearfix"></div>

	<a href="#" class="btn btn-default btn-center forgot-btn">Forgot Password?</a>
	
</form>