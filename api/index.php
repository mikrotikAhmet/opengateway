<?php
/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC.
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * OGCA - Open Gateway Core Application
 * Description of index.php
 **/

// Version
define('_ENGINE_VER','1.5.5.1');

// Basic setup

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('PS') || define('PS', PATH_SEPARATOR);


defined('_ENGINE') || define('_ENGINE', true);
defined('_ENGINE_REQUEST_START') ||
        define('_ENGINE_REQUEST_START', microtime(true));
defined('APPLICATION_PATH_COR') ||
        define('APPLICATION_PATH_COR', realpath(dirname(__DIR__)) . '/');

// Configuration
if (file_exists ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . 'system/config/app.php')){
    require_once ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'system/config/app.php');
} else {
    trigger_error('Configuration file could not be located!');
}

// Startup
if (file_exists ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . 'system/startup.php')){
    require_once ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'system/startup.php');
} else {
    trigger_error('Start Up file could not be located!');
}
 