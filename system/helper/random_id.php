<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/4/15
 * Time: 3:07 PM
 */
/**
 * @package     Semite LLC opengateway
 * @version     random_id.php 1/4/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of random_id.php
 *
 * @author root
 */

/**
 * Generate a random ID or an ID
 * in a specific format
 * @param string $format Format of the ID.
 *      'random'
 *          -OR-
 *      L = Uppercase letter A-Z
 *      l = Lowercase letter a-z
 *      n = Number 1-9
 * @param int $length Max length of the ID.
 */
function generate_id($format = 'random',$length = '20')
{
	$format = trim($format);
	if ($format == "random" || empty($format)) {
		$final_id = md5(time() . rand(1000, 999999999) . uniqid(rand(), true)) . md5(rand(1, 999) . rand(999, 999999));
	} else {
		$final_id = '';
		$letters_lower = 'abcdefghijklmnopqrstuvwxyz';
		$letters_upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$the_format = preg_split('//', $format, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($the_format as $aLetter) {
			if ($aLetter == "l") {
				$temp_rand = rand(0, 25);
				$get_one = $letters_lower[$temp_rand];
				$final_id .= $get_one;
			} elseif ($aLetter == "L") {
				$temp_rand = rand(0, 25);
				$get_one = $letters_upper[$temp_rand];
				$final_id .= $get_one;
			} elseif ($aLetter == "n") {
				$temp_rand = rand(1, 9);
				$final_id .= $temp_rand;
			} else {
				$final_id .= $aLetter;
			}
		}
	}

	$final_id = substr($final_id,0,$length);
	return $final_id;
}

/* End of file random_id.php */