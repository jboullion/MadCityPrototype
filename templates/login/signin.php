<section id="signin-page">
	<div class="container">
		<div class="row">
			<div class="offset-lg-3 offset-md-2 col-lg-6 col-md-8">
				<form action="" method="post" id="signin-form" class="login-form open">
					<div class="g-signin2 float-right" data-onsuccess="googleSignIn"></div>
					<h5>Sign In</h5>
					

					<div class="form-group">
						<!-- <label for="exampleInputEmail1">Email address</label> -->
						<input type="email" class="form-control" id="signin-email" aria-describedby="emailHelp" placeholder="Email" required>
					</div>
					<div class="form-group">
						<!-- <label for="exampleInputPassword1">Password</label> -->
						<input type="password" class="form-control" id="signin-password" placeholder="Password" required>
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

				<form action="" method="post" id="signup-form" class="login-form">
					<h5>Sign Up</h5>

					<div class="form-group">
						<input type="email" class="form-control" id="signup-email" aria-describedby="emailHelp" placeholder="Email" required>
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="signup-password" placeholder="Password" required>
					</div>
					<button type="submit" class="btn btn-primary">Sign Up</button>	
					<a href="#" class="btn btn-default float-right signin-btn">Sign In</a>
				</form>

				<form action="" method="post" id="forgot-form" class="login-form">
					<h5>Forgot Password</h5>

					<div class="form-group">
						<input type="email" class="form-control" id="forgot-email" aria-describedby="emailHelp" placeholder="Email" required>
					</div>
					<button type="submit" class="btn btn-primary">Get New Password</button>
					<a href="#" class="btn btn-default float-right signin-btn">Sign In</a>
				</form>
			</div>
		</div>
	</div>
</section>