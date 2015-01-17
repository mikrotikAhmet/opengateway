<?php
/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2008 - 2014, Semite LLC.
 * @license		http://www.semitellc.com/user_guide/license.html
 * @link		http://www.semitellc.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * opengateway
 * Description of index.php
**/
// Version
define('VERSION', '2.0.0.0');

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('PS') || define('PS', PATH_SEPARATOR);


defined('_ENGINE') || define('_ENGINE', true);
defined('_ENGINE_REQUEST_START') ||
define('_ENGINE_REQUEST_START', microtime(true));
defined('APPLICATION_PATH_COR') ||
define('APPLICATION_PATH_COR', realpath(dirname(__DIR__)) . '/');

// Configuration
if (file_exists(APPLICATION_PATH_COR . 'api/config.php')) {
	require_once(APPLICATION_PATH_COR . 'api/config.php');
} else {
	exit('Configuration file con not be located!');
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
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE application_id = '0'");

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

// RestFull API Response
$api = new Api($registry);
$registry->set('_api', $api);

// Document
$registry->set('document', new Document());

// Currency
$registry->set('currency', new Currency($registry));

// Encryption
$registry->set('encryption', new Encryption($config->get('config_encryption')));

// Account
$registry->set('account', new Account($registry));

// Card Validator
$registry->set('_validateCard', new CreditCardValidator());

// XML Helper
$registry->set('arraytoxml', new ArrayToXML());

// Event
$event = new Event($registry);
$registry->set('event', $event);

$query = $db->query("SELECT * FROM " . DB_PREFIX . "event");

foreach ($query->rows as $result) {
    $event->register($result['trigger'], $result['action']);
}

// Front Controller
$controller = new Front($registry);


// Router
if (isset($request->get['route'])) {
    $action = new Action($request->get['route']);
} else {
    $action = new Action('v1');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();
