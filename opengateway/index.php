<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/2/15
 * Time: 3:32 PM
 */
/**
 * @package     Semite LLC opengateway
 * @version     index.php 1/2/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of index.php
 *
 * @author root
 */
// Version
define('VERSION', '2.0.0.0');

// Basic setup

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('PS') || define('PS', PATH_SEPARATOR);


defined('_ENGINE') || define('_ENGINE', true);
defined('_ENGINE_REQUEST_START') ||
define('_ENGINE_REQUEST_START', microtime(true));
defined('APPLICATION_PATH_COR') ||
define('APPLICATION_PATH_COR', realpath(dirname(__DIR__)) . '/');

// Configuration
if (file_exists(APPLICATION_PATH_COR . 'opengateway/config.php')) {
	require_once(APPLICATION_PATH_COR . 'opengateway/config.php');
} else {
	exit('Configuration file con not be located!');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit;
}

// Startup
if (file_exists(DIR_SYSTEM . 'startup.php')) {
	require_once(DIR_SYSTEM . 'startup.php');
} else {
	exit('Startup file con not be located!');
}

// Registry
$registry = new Registry();

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting");

foreach ($query->rows as $setting) {
	if (!$setting['serialized']) {
		$config->set($setting['key'], $setting['value']);
	} else {
		$config->set($setting['key'], unserialize($setting['value']));
	}
}

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Url
$url = new Url(HTTP_SERVER, $config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
$registry->set('url', $url);

// Log
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;

	// error suppressed with @
	if (error_reporting() === 0) {
		return false;
	}

	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}

	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);

// Cache
$cache = new Cache('file');
$registry->set('cache', $cache);

// Session
$session = new Session();
$registry->set('session', $session);

// Language
$languages = array();

$query = $db->query("SELECT * FROM `" . DB_PREFIX . "language`");

foreach ($query->rows as $result) {
	$languages[$result['code']] = $result;
}

$config->set('config_language_id', $languages[$config->get('config_admin_language')]['language_id']);

// Language
$language = new Language($languages[$config->get('config_admin_language')]['directory']);
$language->load($languages[$config->get('config_admin_language')]['filename']);
$registry->set('language', $language);

// Document
$registry->set('document', new Document());

// Currency
$registry->set('currency', new Currency($registry));

// User
$registry->set('user', new User($registry));

// Event
$event = new Event($registry);
$registry->set('event', $event);

$query = $db->query("SELECT * FROM " . DB_PREFIX . "event");

foreach ($query->rows as $result) {
	$event->register($result['trigger'], $result['action']);
}

// Front Controller
$controller = new Front($registry);

// Login
$controller->addPreAction(new Action('common/login/check'));

// Permission
$controller->addPreAction(new Action('error/permission/check'));

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/dashboard');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();