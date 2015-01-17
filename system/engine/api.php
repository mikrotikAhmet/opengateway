<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');


/**
 * theHive Gaming Platform
 *
 * @category   PhpStorm
 * @package    api_thehive.com
 * @copyright  Copyright 2009-2014 Egaming Cunsultant Ltd. Developments
 * @license    http://www.egamingc.net/license/
 * @version    api.php 10/22/14 ahmet $
 * @author     Ahmet GOUDENOGLU <agoudenoglu@egamingc.com>
 */

/**
 * @category   PhpStorm
 * @package    api_thehive.com
 * @copyright  Copyright 2009-2014 Egaming Cunsultant Ltd. Developments
 * @license    http://www.egamingc.net/license/
 */

class Api extends REST {

	private $apiKey = true;

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->load = $registry->get('load');
		$this->config = $registry->get('config');
	}

	public function processApi($data, $status) {


		if (!$this->apiKey) {

			$status = 507;

			$auth['code'] = $status;
			$auth['status'] = $this->getStatusMessage($status);

			$this->response($this->json($auth), $status);
		}
		if (isset($data) && !empty($data)) {

			$data['code'] = $status;
			$data['status'] = $this->getStatusMessage($status);

			$this->response($this->json($data), $status);

		} else {

			$error['code'] = $status;
			$error['status'] = $this->getStatusMessage($status);

			$this->response($this->json($error), $status);
		}
	}

	public function getStatusMessage($code) {

		$status = $this->db->query("SELECT * FROM ".DB_PREFIX."api_response WHERE `code` = '".(int) $code."'");

		return ($status->row['code']) ? $status->row['description'] : $this->getStatusMessage(200);
	}

	private function json($data) {

		if (is_array($data)) {
			return json_encode($data);
		}
	}

}