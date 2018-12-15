<?php 
global $PDO, $STATS, $USER;

if($_SERVER['HTTP_HOST'] == 'localhost'){
	define('ENVIRONMENT', 'dev');
}else{
	define('ENVIRONMENT', 'live');
}

// functions used throuhgout the site
require_once('functions.php');

// All Classes loaded here
require_once('classes.php');

// Setup Database object
$PDO = setup_pdo();

// Setup the current user on the site
$USER = site_get_user($PDO, 1);

// Setup the current character on the site
$CHARACTER = site_get_character($PDO, 1);

// get an array of stats used in various calculations
$STATS = rules_get_stats($PDO);

// Equipment slots
$SLOTS = array('Head', 'Torso', 'Hands', 'Legs', 'Feet', 'Accessory' );

// Effects
$POWER_EFFECTS = array(
	array(
		'damage' => 4,
		'roll' => -1,
		'dot' => -1,
	),
	array(
		'damage' => 8,
		'roll' => -2,
		'dot' => -2,
	),
	array(
		'damage' => 12,
		'roll' => -3,
		'dot' => -3,
	),
);

// functions used to display components dynamically
require_once('display-functions.php');