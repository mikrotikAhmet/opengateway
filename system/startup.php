<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/2/15
 * Time: 3:36 PM
 */
/**
 * @package     Semite LLC opengateway
 * @version     startup.php 1/2/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of startup.php
 *
 * @author root
 */
// Error Reporting
error_reporting(E_ALL);

// Transaction Types
define('TRX_3DSECURE', '3D-Secure');
define('TRX_NORMAL', 'Normal');
define('TRX_CHARGE', 'Charge');
define('TRX_AUTHORIZE', 'Authorize');
define('TRX_CAPTURE', 'Capture');
define('TRX_VOID', 'Void');
define('TRX_REFUND', 'Refund');
define('TRX_SENT', 'Sent');
define('TRX_RECEIVE', 'Received');
define('TRX_WITHDRAW', 'Withdraw');
define('TRX_DEPOSIT', 'Deposit');
define('TRX_VERIFY', 'Verification');

// Transaction Statuses
define('TRX_ST_PROCESSED', 'Processed');
define('TRX_ST_FAILED', 'Failed');

// PREFIX
define('CUSTOMER_PREFIX','cus_');
define('CARD_PREFIX', 'card_');

// Check Version
if (version_compare(phpversion(), '5.3.0', '<') == true) {
	exit('PHP5.3+ Required');
}

if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

// Windows IIS Compatibility
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['SCRIPT_FILENAME'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

	if (isset($_SERVER['QUERY_STRING'])) {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}

if (!isset($_SERVER['HTTP_HOST'])) {
	$_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
}

// Check if SSL
if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
	$_SERVER['HTTPS'] = true;
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$_SERVER['HTTPS'] = true;
} else {
	$_SERVER['HTTPS'] = false;
}

// Modification Override
function modification($filename) {
	if (!defined('DIR_CATALOG')) {
		$file = DIR_MODIFICATION . 'catalog/' . substr($filename, strlen(DIR_APPLICATION));
	} else {
		$file = DIR_MODIFICATION . 'admin/' .  substr($filename, strlen(DIR_APPLICATION));
	}

	if (substr($filename, 0, strlen(DIR_SYSTEM)) == DIR_SYSTEM) {
		$file = DIR_MODIFICATION . 'system/' . substr($filename, strlen(DIR_SYSTEM));
	}

	if (file_exists($file)) {
		return $file;
	} else {
		return $filename;
	}
}

// Autoloader
function autoload($class) {
	$file = DIR_SYSTEM . 'library/' . str_replace('\\', '/', strtolower($class)) . '.php';

	if (file_exists($file)) {
		include(modification($file));

		return true;
	} else {
		return false;
	}
}

spl_autoload_register('autoload');
spl_autoload_extensions('.php');

// Engine
require_once(modification(DIR_SYSTEM . 'engine/rest.php'));
require_once(modification(DIR_SYSTEM . 'engine/api.php'));
require_once(modification(DIR_SYSTEM . 'engine/action.php'));
require_once(modification(DIR_SYSTEM . 'engine/controller.php'));
require_once(modification(DIR_SYSTEM . 'engine/event.php'));
require_once(modification(DIR_SYSTEM . 'engine/front.php'));
require_once(modification(DIR_SYSTEM . 'engine/loader.php'));
require_once(modification(DIR_SYSTEM . 'engine/model.php'));
require_once(modification(DIR_SYSTEM . 'engine/registry.php'));

// Helper
require_once(DIR_SYSTEM . 'helper/json.php');
require_once(DIR_SYSTEM . 'helper/utf8.php');
require_once(DIR_SYSTEM . 'helper/unique.php');
require_once(DIR_SYSTEM . 'helper/cardValidator.php');
require_once(DIR_SYSTEM . 'helper/uuid.php');

// Third-Party Payvision
require_once(DIR_SYSTEM . 'third_party/payvision/client.php');
require_once(DIR_SYSTEM . 'third_party/payvision/exception.php');
require_once(DIR_SYSTEM . 'third_party/payvision/operation.php');
require_once(DIR_SYSTEM . 'third_party/payvision/translator.php');
require_once(DIR_SYSTEM . 'third_party/payvision/basicoperations/authorize.php');
require_once(DIR_SYSTEM . 'third_party/payvision/basicoperations/capture.php');
require_once(DIR_SYSTEM . 'third_party/payvision/basicoperations/void.php');
require_once(DIR_SYSTEM . 'third_party/payvision/basicoperations/payment.php');
require_once(DIR_SYSTEM . 'third_party/payvision/basicoperations/refund.php');
require_once(DIR_SYSTEM . 'third_party/payvision/threedsecureoperations/checkenrollment.php');
require_once(DIR_SYSTEM . 'third_party/payvision/threedsecureoperations/paymentusingintegratedmpi.php');
require_once(DIR_SYSTEM . 'third_party/payvision/threedsecureoperations/authorizeusingintegratedmpi.php');