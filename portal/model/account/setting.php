<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/18/15
 * Time: 1:11 PM
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

class ModelAccountSetting extends Model {

	public function getAccount($account_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account WHERE account_id = '" . (int)$account_id . "'");

		return $query->row;
	}

	public function editAccount($account_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "account SET
		api_id = '" . $this->db->escape($data['api_id']) . "',
		api_secret = '" . $this->db->escape($data['secret_key']) . "' WHERE account_id = '" . (int)$account_id . "'");

		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "account SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE account_id = '" . (int)$account_id . "'");
		}

	}
} 