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
 * Description of api.php Class
**/


class Api extends REST {



    public function __construct($registry) {

        $this->db = $registry->get('db');
    }

    public function processApi($data, $status) {

        if (isset($data) && !empty($data)) {

            $data['code'] = $status;
            $data['stat'] = $this->getStatusMessage($status);

            $this->response($this->json($data), $status);

        } else {

            $error['code'] = $status;
            $error['stat'] = $this->getStatusMessage($status);

            $this->response($this->json($error), $status);
        }
    }

    public function getStatusMessage($code) {

        $status = require_once (DIR_SYSTEM.'config/api_response.php');
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    private function json($data) {

        if (is_array($data)) {
            return json_encode($data);
        }
    }

}