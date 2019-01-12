<head>
	<title>Mad City: Evolution</title>
	<meta name="Description" content="Table Top RPG by James Boullion">
	<meta charset="utf-8">
	
	<meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
	<meta http-equiv="Cache-control" content="public">

	<!-- icons -->
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="/favicons/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="/favicons/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="Mad City"/>
	<meta name="msapplication-TileColor" content="#333333" />
	<meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="/favicons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="/favicons/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="/favicons/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="/favicons/mstile-310x310.png" />


	<!-- PWA Manifest -->
	<link rel="manifest" href="/manifest.json">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Mad City">

	
	<!-- Custom Styles -->
	<?php 
		if(ENVIRONMENT !== 'dev'){
			echo '<link rel="stylesheet" href="/css/live.css?v='.date('Ymd').'" />';
		}else{
			echo '<link rel="stylesheet" href="/css/dev.css?v='.time().'" />';
		}
	?>

	<!-- jQuery 3 ( we don't want to have to reach out to an outside site When using service workers )
	<script
		src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
		crossorigin="anonymous"></script>
	-->
		
	<script src="/js/jquery-3.3.1.min.js" ></script>


	<!-- Google APIs -->
	<!-- https://developers.google.com/identity/sign-in/web/sign-in -->
	<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
	<meta name="google-signin-client_id" content="63734584828-cpm6irahebhdeq12o019v5ep90lmlrkf.apps.googleusercontent.com">
		
</head>