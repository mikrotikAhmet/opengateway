<?php
// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER['HTTP_HOST'].'/');

// HTTPS
define('HTTPS_SERVER', 'https://'.$_SERVER['HTTP_HOST'].'/');

// DIR
define('DIR_APPLICATION', APPLICATION_PATH_COR.'portal/');
define('DIR_SYSTEM', APPLICATION_PATH_COR.'system/');
define('DIR_LANGUAGE', APPLICATION_PATH_COR.'portal/language/');
define('DIR_TEMPLATE', APPLICATION_PATH_COR.'portal/view/template/');
define('DIR_CONFIG', APPLICATION_PATH_COR.'system/config/');
define('DIR_IMAGE', APPLICATION_PATH_COR.'image/');
define('DIR_CACHE', APPLICATION_PATH_COR.'system/cache/');
define('DIR_DOWNLOAD', APPLICATION_PATH_COR.'system/download/');
define('DIR_DOCUMENT', APPLICATION_PATH_COR.'system/document/');
define('DIR_UPLOAD', APPLICATION_PATH_COR.'system/upload/');
define('DIR_LOGS', APPLICATION_PATH_COR.'system/logs/');
define('DIR_MODIFICATION', APPLICATION_PATH_COR.'system/modification/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'ahm671et');
define('DB_DATABASE', 'opengateway');
define('DB_PREFIX', 'engine4_');
