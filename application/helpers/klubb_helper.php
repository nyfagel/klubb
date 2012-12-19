<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helpers for Klubb.
 * 
 * @package		helpers
 * @author		Jan Lindblom <jan@nyfagel.se>
 * @copyright	Copyright (c) 2012, Ny fågel.
 * @license		MIT
 * @version		1.0
 */

if ( ! function_exists('very_random_string')) {
	/**
	 * Return a very random string, suitable as a password.
	 * 
	 * @param int $length the desired length of the string. Defaults to 12.
	 * @param mixed $policy an array with any combination of the following strings:
	          'alpha', 'num', 'special'. Defaults to array('alpha','num').
	 * @return string a very random string.
	 */
	function very_random_string($length = 12, $policy = array('alpha','num')) {
		$characters = '';
		foreach ($policy as $pol) {
			if ($pol == 'alpha') {
				$characters .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			} else if ($pol == 'num') {
				$characters .= '0123456789';
			} else if ($pol == 'special') {
				$characters .= '!*.,:;-=@#()';
			}
		}
		srand((double)microtime()*1000000);
		$mod = strlen($characters);
		$randstring = '';
		while ($length--) {
			$randstring .= substr($characters,rand()%$mod,1);
		}
		return $randstring;
	}
}
?>