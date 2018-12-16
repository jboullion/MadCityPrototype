<?php 
require_once('classes/Utilities.php');
require_once('database.php');

$user_id = 1;
$character_id = 1;

// Setup the current user on the site
$USER = site_get_user($PDO, $user_id);

// Setup the current character on the site
$CHARACTER = new Character($PDO, $character_id, $user_id);

// get an array of stats used in various calculations
$STATS = rules_get_stats($PDO);

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
