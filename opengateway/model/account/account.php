<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 1:13 PM
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

class ModelAccountAccount extends Model {

	public function addAccount($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "account SET
		account_group_id = '" . (int)$data['account_group_id'] . "',
		username = '" . $this->db->escape($data['username']) . "',
		firstname = '" . $this->db->escape($data['firstname']) . "',
		lastname = '" . $this->db->escape($data['lastname']) . "',
		email = '" . $this->db->escape($data['email']) . "',
		telephone = '" . $this->db->escape($data['telephone']) . "',
		salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "',
		password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "',
		country_id = '" . (int)$data['country_id'] . "',
		currency_code = '" . $this->db->escape($data['currency_code']) . "',
		language_code = '" . $this->db->escape($data['language_code']) . "',
		address_1 = '" . $this->db->escape($data['address_1']) . "',
		address_2 = '" . $this->db->escape($data['address_2']) . "',
		city = '" . $this->db->escape($data['city']) . "',
		zone_id = '" . (int)$data['zone_id'] . "',
		postal_code = '" . $this->db->escape($data['postcode']) . "',
		gmt_offset = '" . $this->db->escape($data['gmt_offset']) . "',
		api_id = '" . $this->db->escape($data['api_id']) . "',
		api_secret = '" . $this->db->escape($data['secret_key']) . "',
		status = '" . (int)$data['status'] . "',
		livemode = '" . (int)$data['livemode'] . "',
        merchantID = '" . $this->db->escape($data['merchantID']) . "',
		merchantGUID = '" . $this->db->escape($data['merchantGUID']) . "',
		merchantID_amex = '" . $this->db->escape($data['merchantID_amex']) . "',
		merchantGUID_amex = '" . $this->db->escape($data['merchantGUID_amex']) . "',
		dynamicDescriptor = '" . $this->db->escape($data['descriptor']) . "',
		date_added = NOW()");

		$account_id = $this->db->getLastId();

	}

	public function editAccount($account_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "account SET
		account_group_id = '" . (int)$data['account_group_id'] . "',
		username = '" . $this->db->escape($data['username']) . "',
		firstname = '" . $this->db->escape($data['firstname']) . "',
		lastname = '" . $this->db->escape($data['lastname']) . "',
		email = '" . $this->db->escape($data['email']) . "',
		telephone = '" . $this->db->escape($data['telephone']) . "',
		country_id = '" . (int)$data['country_id'] . "',
		currency_code = '" . $this->db->escape($data['currency_code']) . "',
		language_code = '" . $this->db->escape($data['language_code']) . "',
		address_1 = '" . $this->db->escape($data['address_1']) . "',
		address_2 = '" . $this->db->escape($data['address_2']) . "',
		city = '" . $this->db->escape($data['city']) . "',
		zone_id = '" . (int)$data['zone_id'] . "',
		postal_code = '" . $this->db->escape($data['postcode']) . "',
		gmt_offset = '" . $this->db->escape($data['gmt_offset']) . "',
		api_id = '" . $this->db->escape($data['api_id']) . "',
		api_secret = '" . $this->db->escape($data['secret_key']) . "',
		status = '" . (int)$data['status'] . "',
		livemode = '" . (int)$data['livemode'] . "',
		merchantID = '" . $this->db->escape($data['merchantID']) . "',
		merchantGUID = '" . $this->db->escape($data['merchantGUID']) . "',
		merchantID_amex = '" . $this->db->escape($data['merchantID_amex']) . "',
		merchantGUID_amex = '" . $this->db->escape($data['merchantGUID_amex']) . "',
		dynamicDescriptor = '" . $this->db->escape($data['descriptor']) . "' WHERE account_id = '" . (int)$account_id . "'");

		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "account SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE account_id = '" . (int)$account_id . "'");
		}

	}

	public function editToken($account_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "account SET token = '" . $this->db->escape($token) . "' WHERE account_id = '" . (int)$account_id . "'");
	}

	public function deleteAccount($account_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "account WHERE account_id = '" . (int)$account_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "account_ip WHERE account_id = '" . (int)$account_id . "'");
	}

	public function getAccount($account_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account WHERE account_id = '" . (int)$account_id . "'");

		return $query->row;
	}

	public function getAccountByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getAccountByUsername($username) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account WHERE username = '" . $this->db->escape($username) . "'");

		return $query->row;
	}

	public function getAccounts($data = array()) {
		$sql = "SELECT *, CONCAT(a.firstname, ' ', a.lastname) AS name, agd.name AS account_group FROM " . DB_PREFIX . "account a LEFT JOIN " . DB_PREFIX . "account_group_description agd ON (a.account_group_id = agd.account_group_id) WHERE agd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(a.firstname, ' ', a.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "a.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_account_group_id'])) {
			$implode[] = "a.account_group_id = '" . (int)$data['filter_account_group_id'] . "'";
		}

		if (!empty($data['filter_ip'])) {
			$implode[] = "a.account_id IN (SELECT account_id FROM " . DB_PREFIX . "account_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$implode[] = "a.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_approved']) && $data['filter_approved'] !== null) {
			$implode[] = "a.approved = '" . (int)$data['filter_approved'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(a.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'name',
			'a.email',
			'account_group',
			'a.status',
			'a.approved',
			'a.ip',
			'a.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function approve($account_id) {
		$account_info = $this->getAccount($account_id);

		if ($account_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "account SET approved = '1' WHERE account_id = '" . (int)$account_id . "'");

//			$this->load->language('mail/account');

//			$this->load->model('setting/application');
//
//			$store_info = $this->model_setting_application->getApplication($account_info['application_id']);
//
//			if ($store_info) {
//				$store_name = $store_info['name'];
//				$store_url = $store_info['url'] . 'index.php?route=account/login';
//			} else {
//				$store_name = $this->config->get('config_name');
//				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
//			}
//
//			$message  = sprintf($this->language->get('text_approve_welcome'), $store_name) . "\n\n";
//			$message .= $this->language->get('text_approve_login') . "\n";
//			$message .= $store_url . "\n\n";
//			$message .= $this->language->get('text_approve_services') . "\n\n";
//			$message .= $this->language->get('text_approve_thanks') . "\n";
//			$message .= $store_name;
//
//			$mail = new Mail($this->config->get('config_mail'));
//			$mail->setTo($account_info['email']);
//			$mail->setFrom($this->config->get('config_email'));
//			$mail->setSender($store_name);
//			$mail->setSubject(sprintf($this->language->get('text_approve_subject'), $store_name));
//			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
//			$mail->send();
		}
	}

	public function getTotalAccounts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_newsletter']) && $data['filter_newsletter'] !== null) {
			$implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}

		if (!empty($data['filter_account_group_id'])) {
			$implode[] = "account_group_id = '" . (int)$data['filter_account_group_id'] . "'";
		}

		if (!empty($data['filter_ip'])) {
			$implode[] = "account_id IN (SELECT account_id FROM " . DB_PREFIX . "account_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_approved']) && $data['filter_approved'] !== null) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalAccountsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account WHERE status = '0' OR approved = '0'");

		return $query->row['total'];
	}


	public function getTotalAccountsByAccountGroupId($account_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account WHERE account_group_id = '" . (int)$account_group_id . "'");

		return $query->row['total'];
	}

	public function addTransaction($account_id, $description = '', $amount = '', $order_id = 0) {
//		$account_info = $this->getAccount($account_id);
//
//		if ($account_info) {
//			$this->db->query("INSERT INTO " . DB_PREFIX . "account_transaction SET account_id = '" . (int)$account_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
//
//			$this->load->language('mail/account');
//
//			$this->load->model('setting/store');
//
//			$store_info = $this->model_setting_store->getStore($account_info['store_id']);
//
//			if ($store_info) {
//				$store_name = $store_info['name'];
//			} else {
//				$store_name = $this->config->get('config_name');
//			}
//
//			$message  = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
//			$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($account_id)));
//
//			$mail = new Mail($this->config->get('config_mail'));
//			$mail->setTo($account_info['email']);
//			$mail->setFrom($this->config->get('config_email'));
//			$mail->setSender($store_name);
//			$mail->setSubject(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')));
//			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
//			$mail->send();
//		}
	}

	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "transaction WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getTransactions($account_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT *,(t.transaction_id) AS transaction FROM " . DB_PREFIX . "transaction t LEFT JOIN ".DB_PREFIX."transaction_log tl ON (t.transaction_id = tl.reference) WHERE t.account_id = '" . (int)$account_id . "' ORDER BY t.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalTransactions($account_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "transaction WHERE account_id = '" . (int)$account_id . "'");

		return $query->row['total'];
	}

	public function getTransactionTotal($account_id,$livemode) {
        $query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "transaction WHERE (account_id = '" .  (int) $account_id. "' AND status = '1' AND livemode = '".(int) $livemode."') AND (charged = '1' OR captured = '1' OR received = '1' OR sent = '1')");

        $fees = $this->getFees($account_id,$livemode);

        $balance = $query->row['total'] - $fees;

        return $balance;
	}

    public function getFees($account_id,$livemode) {

        $query = $this->db->query("SELECT SUM(fee) AS total FROM " . DB_PREFIX . "transaction WHERE (account_id = '" .  (int) $account_id. "' AND status = '1' AND livemode = '".(int) $livemode."') AND (charged = '1' OR captured = '1' OR received = '1' OR sent = '1')");

        return $query->row['total'];
    }


	public function getIps($account_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_ip WHERE account_id = '" . (int)$account_id . "'");

		return $query->rows;
	}

	public function getTotalIps($account_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account_ip WHERE account_id = '" . (int)$account_id . "'");

		return $query->row['total'];
	}

	public function getTotalAccountsByIp($ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account_ip WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->row['total'];
	}

	public function addBanIp($ip) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "account_ban_ip` SET `ip` = '" . $this->db->escape($ip) . "'");
	}

	public function removeBanIp($ip) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "account_ban_ip` WHERE `ip` = '" . $this->db->escape($ip) . "'");
	}

	public function getTotalBanIpsByIp($ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "account_ban_ip` WHERE `ip` = '" . $this->db->escape($ip) . "'");

		return $query->row['total'];
	}
}