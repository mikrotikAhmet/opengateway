<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/12/14
 * Time: 8:46 PM
 */
function crc_string($str, $len){
	return substr(sprintf("%u", crc32($str)),0,$len);
}