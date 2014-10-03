<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

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
 * Description of db.php Class
**/


class DB {
    private $driver;

    public function __construct($driver, $hostname, $username, $password, $database) {
        $file = DIR_DATABASE . $driver . '.php';

        if (file_exists($file)) {
            require_once($file);

            $class = 'DB' . $driver;

            $this->driver = new $class($hostname, $username, $password, $database);
        } else {
            exit('Error: Could not load database driver type ' . $driver . '!');
        }
    }

    public function query($sql) {
        return $this->driver->query($sql);
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function countAffected() {
        return $this->driver->countAffected();
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }
}