<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/9/15
 * Time: 7:29 PM
 */
/**
 * @package     Semite LLC semite.com
 * @version     index.php 1/9/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of index.php
 *
 * @author root
 */
// Constants
define('_ENGINE_R_BASE', dirname($_SERVER['SCRIPT_NAME']));
define('_ENGINE_R_FILE', $_SERVER['SCRIPT_NAME']);
define('_ENGINE_R_REL', 'opengateway');
define('_ENGINE_R_TARG', 'index.php');

// Main
include dirname(__FILE__) . DIRECTORY_SEPARATOR
	. _ENGINE_R_REL . DIRECTORY_SEPARATOR
	. _ENGINE_R_TARG;