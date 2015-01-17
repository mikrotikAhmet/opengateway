<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/11/15
 * Time: 9:55 AM
 */

/**
 * Smatsa Question Bank
 *
 * @category   PhpStorm
 * @package    smatsa
 * @copyright  Copyright 2009-2014 Semite d.o.o. Developments
 * @license    http://www.semitepayment.com/license/
 * @version    home.php 10/22/14 ahmet $
 * @author     Ahmet GOUDENOGLU <ahmet.gudenoglu@semitepayment.com>
 */

/**
 * @category   PhpStorm
 * @package    smatsa
 * @copyright  Copyright 2009-2014 Semite d.o.o. Developments
 * @license    http://www.semitepayment.com/license/
 */

class ModelAccountActivity extends Model {

	public function addActivity($key, $data) {

		if (isset($data['account_id'])) {
			$account_id = $data['account_id'];
		} else {
			$account_id = 0;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "account_activity` SET `account_id` = '" . $this->db->escape($account_id) . "', `key` = '" . $this->db->escape($key) . "', `data` = '" . $this->db->escape(serialize($data)) . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW()");

		$activity_id =  $this->db->getLastId();

		return $activity_id;
	}
} 