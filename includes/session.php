<?php 
/**
 * Check a User's SESSION and also provide functions related to user sessions
 */

session_start();

if(empty($_SESSION['email'])){
	jb_redirect('/');
	exit;
}