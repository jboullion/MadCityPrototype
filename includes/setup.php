<?php 
require_once('database.php');

$user_id = 1;
$character_id = 1;

// Setup the current user on the site
$USER = site_get_user($PDO, $user_id);

// Setup the current character on the site
$CHARACTER = new Character($PDO, $character_id, $user_id);

define('BASE_URL', $_SERVER['proto'].'://'.$_SERVER['HTTP_HOST']);