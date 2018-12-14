<?php 

/**
 * Debug function display cleaner information
 * 
 * @param mixed $data Any PHP variable you want to debug
 */
function jb_print($data){
	echo '<pre class="jb-print">'.print_r($data, true).'</pre>';
}



/**
 * Setup Database Connection / PDO Object
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



/**
 * Return an array of stats used throughout the site
 * 
 * @param PDO $PDO PDO Object
 * @return array An array of stats and their IDs
 */
function rules_get_stats(PDO $PDO){
	$stmt = $PDO->prepare('SELECT * FROM stats');
	$stmt->execute();
	$stats = $stmt->fetchAll();
	$STATS = array();
	if(! empty($stats)){
		foreach($stats as $stat){
			$STATS[$stat['stat_id']] = $stat['stat_name'];
		}
		return $STATS;
	}else{
		return false;
	}
}



/**
 * Return an array of user information
 * 
 * @param PDO $PDO PDO Object
 * @param int $user_id The user ID of the user info to get
 * @param return $user object 
 * 
 * TODO: Setup a User Class and return that
 */
function site_get_user(PDO $PDO, $user_id){
	$stmt = $PDO->prepare("SELECT user_email FROM users WHERE user_id = {$user_id} LIMIT 1");
	$stmt->execute();
	return $stmt->fetch();
}


/**
 * Return an array of user information
 * 
 * @param PDO $PDO PDO Object
 * @param int $user_id The user ID of the user info to get
 * 
 * TODO: Setup a User Class and return that
 */
function site_get_character(PDO $PDO, $char_id){
	$stmt = $PDO->prepare("SELECT * FROM characters WHERE character_id = :char_id LIMIT 1");
	$stmt->execute( array('char_id' => $char_id) );
	$CHARACTER = $stmt->fetch();

	//convert from JSON back into PHP arrays
	$CHARACTER['vitals'] = json_decode($CHARACTER['character_vitals'], true);
	$CHARACTER['stats'] = json_decode($CHARACTER['character_stats'], true);
	$CHARACTER['skills'] = json_decode($CHARACTER['character_skills'], true);
	$CHARACTER['powers'] = json_decode($CHARACTER['character_powers'], true);
	$CHARACTER['equipment'] = json_decode($CHARACTER['character_equipment'], true);

	return $CHARACTER;
}

