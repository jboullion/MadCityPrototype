<?php 





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

