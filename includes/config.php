<?php 
global $PDO, $STATS, $USER;

if($_SERVER['HTTP_HOST'] == 'localhost'){
	define('ENVIRONMENT', 'dev');
}else{
	define('ENVIRONMENT', 'live');
}

// Setup Database object
$PDO = setup_pdo();

// Setup the current user on the site
$USER = site_get_user($PDO, 1);

// Setup the current character on the site
$CHARACTER = site_get_character($PDO, 1);

// get an array of stats used in various calculations
$STATS = rules_get_stats($PDO);