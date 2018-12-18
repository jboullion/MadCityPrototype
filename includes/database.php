<?php 

if($_SERVER['HTTP_HOST'] == 'madcity.local'){
	define('ENVIRONMENT', 'dev');

	//set false if you want to disable debug messages
	define('DEBUG', true);
}else{
	define('ENVIRONMENT', 'live');
	define('DEBUG', false);
}

if(DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

/**
 * Setup Database Connection / PDO Object
 * 
 * TODO: Do we move this elsewhere? Leaving here provides the one stop for database 
 */
function setup_pdo(){
	if(ENVIRONMENT == 'dev'){
		$host = 'localhost';
		$db   = 'madcity';
		$user = 'root';
		$pass = '';
	}else{
		$host = 'localhost';
		$db   = 'jboullio_madcity';
		$user = 'jboullio_james';
		$pass = 'JimmYB123!';
	}

	$charset = 'utf8mb4';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

	$options = [
		PDO::ATTR_ERRMODE 				=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES 		=> false,
	];

	try {
		return new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
}

// Setup Database object
$PDO = setup_pdo();