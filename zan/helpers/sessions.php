<?php
/**
 * ZanPHP
 *
 * An open source agile and rapid development framework for PHP 5
 *
 * @package		ZanPHP
 * @author		MilkZoft Developer Team
 * @copyright	Copyright (c) 2011, MilkZoft, Inc.
 * @license		http://www.zanphp.com/documentation/en/license/
 * @link		http://www.zanphp.com
 * @version		1.0
 */
 
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

/**
 * Sessions Helper
 *
 * 
 *
 * @package		ZanPHP
 * @subpackage	core
 * @category	helpers
 * @author		MilkZoft Developer Team
 * @link		http://www.zanphp.com/documentation/en/helpers/security_helper
 */

function cacheSession($cacheID) {
	if(SESSION("ZanUser")) {
		return $cacheID .".". SESSION("ZanUser");
	}

	return $cacheID .".guest";
}

function COOKIE($cookie) {
	if(isset($_COOKIE[$cookie])) {
		return filter($_COOKIE[$cookie]);
	} else {
		return FALSE;
	}
}

/**
 * createCookie
 *
 * Sets a cookie
 * 
 * @param string $cookie
 * @param string $value
 * @param string $redirect
 * @param string $URL      = _webBase
 * @param int    $time     = 604800
 * @return void
 */ 
function createCookie($cookie = NULL, $value, $time = 604800, $redirect = FALSE, $URL = _webBase) {		
	setcookie($cookie, $value, time() + $time, "/");
	
	if($redirect) {
		redirect($URL);		
	}
}

function COOKIE($cookie) {
	if(isset($_COOKIE[$cookie])) {
		return $_COOKIE[$cookie];
	}

	return FALSE;
}

/**
 * SESSION
 *
 * Returns a $_SESSION index variable value
 * 
 * @param string $session
 * @return mixed
 */ 
function SESSION($session, $value = FALSE) {
	if($value === FALSE) {
		if(isset($_SESSION[$session])) {
			return $_SESSION[$session];
		} else {
			return FALSE;
		}
	} else {
		$_SESSION[$session] = $value;
	}
	
	return TRUE;
}

/**
 * unsetCookie
 *
 * Removes a cookie
 * 
 * @param $cookie
 * @param $URL    = _webBase
 * @return void
 */ 
function unsetCookie($cookie, $URL = FALSE) {
	setcookie($cookie);	
	
	if($URL) {
		redirect($URL);
	} else {
		redirect();
	}
}

/**
 * unsetSessions
 *
 * Unsets all started sessions variables
 * 
 * @param $URL    = _webBase
 * @return void
 */ 
function unsetSessions($URL = FALSE) {
	session_unset(); 
	session_destroy();	
	
	if($URL) {
		redirect($URL);
	} else {
		redirect();
	}
}
