<section id="main-navigation">
	<div class="container">
		<div class="row">
			<div class="col-12">

				<?php if(true): //Not logged in ?>
					<div class="text-center">
						<h1>Mad City</h1>
					</div>
				<?php else: ?>
				<?php
					//Logged in 
					/*

						//TODO: setup login actions and check here if the user is logged in

						<div id="logo">
							<h1>Mad City</h1>
						</div>
						
						<div class="menu-toggle d-print-none">
							<i class="fal fa-bars"></i>
						</div>
						
						<div id="user-info">
							<a href="#" onclick="googleSignOut();" class="btn btn-default">Sign out</a>
						</div>

						<div class="clearfix"></div>
					*/
					//}
				?>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</section>

<?php require_once('menu.php');