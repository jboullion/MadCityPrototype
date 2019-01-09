<?php 
/**
 * Check a User's SESSION and also provide functions related to user sessions
 */

session_start();

if(empty($_SESSION['email']) || empty($_SESSION['user_id'])){
	mc_redirect('/');
	exit;
}
