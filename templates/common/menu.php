<div id="menu-shade"></div>
<div id="menu" class="d-print-none">
	<div class="menu-toggle">
		<i class="far fa-times"></i>
	</div>
	<ul>
		<li><a href="/characters/"><i class="far fa-fw fa-users"></i> Characters</a></li>
		<li><a href="/parties/"><i class="far fa-fw fa-users-crown"></i> Party</a></li>
		<li><a href="/rules/"><i class="far fa-fw fa-books"></i> Rules</a></li>
		<li><a href="/profile/"><i class="far fa-fw fa-user-edit"></i> Profile</a></li>
		<li><a href="#" onclick="jbSignOut(event, '<?php echo $_SESSION['email']; ?>');"><i class="far fa-fw fa-sign-out"></i> Sign out</a></li>
	</ul>
</div>