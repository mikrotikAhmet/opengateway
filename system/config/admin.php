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
 * Description of admin.php
 **/

// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST'].'/admin/');
define('HTTP_PUBLIC', 'http://'.$_SERVER['HTTP_HOST'].'/');

// HTTPS
define('HTTPS_SERVER', 'https://'.$_SERVER['HTTP_HOST'].'/admin/');
define('HTTPS_PUBLIC', 'https://'.$_SERVER['HTTP_HOST'].'/');

// DIR
define('DIR_APPLICATION', APPLICATION_PATH_COR.'admin/');
define('DIR_SYSTEM', APPLICATION_PATH_COR.'system/');
define('DIR_DATABASE', APPLICATION_PATH_COR.'system/database/');
define('DIR_LANGUAGE', APPLICATION_PATH_COR.'admin/language/');
define('DIR_TEMPLATE', APPLICATION_PATH_COR.'admin/view/template/');
define('DIR_CONFIG', APPLICATION_PATH_COR.'system/config/');
define('DIR_IMAGE', APPLICATION_PATH_COR.'image/');
define('DIR_CACHE', APPLICATION_PATH_COR.'system/cache/');
define('DIR_DOWNLOAD', APPLICATION_PATH_COR.'download/');
define('DIR_DOCUMENY', APPLICATION_PATH_COR.'document/');
define('DIR_LOGS', APPLICATION_PATH_COR.'system/logs/');
define('DIR_PUBLIC', APPLICATION_PATH_COR.'public/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'ahm671et');
define('DB_DATABASE', 'semite');
define('DB_PREFIX', 'engine4_');