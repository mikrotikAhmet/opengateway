<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/1/15
 * Time: 1:05 PM
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

class Account {
	private $account_id;
	private $account_group_id;
	private $livemode;
	private $account_detail_id;
    private $merchantID;
    private $merchantGUID;
    private $merchantID_amex;
    private $merchantGUID_amex;
	private $firstname;
	private $lastname;
	private $email;
    private $account_currency;
    private $account_language;
    private $api_id;
    private $secret_key;

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
        $this->currency = $registry->get('currency');

		if (isset($this->session->data['account_id'])) {
			$account_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account WHERE account_id = '" . $this->db->escape($this->session->data['account_id']) . "' AND status = '1'");

			if ($account_query->num_rows) {
				$this->account_id = $account_query->row['account_id'];
				$this->account_group_id = $account_query->row['account_group_id'];
				$this->firstname = $account_query->row['firstname'];
				$this->lastname = $account_query->row['lastname'];
				$this->email = $account_query->row['email'];
                $this->account_currency = $account_query->row['currency_code'];
                $this->account_language = $account_query->row['language_code'];
                $this->api_id = $account_query->row['api_id'];
                $this->secret_key = $account_query->row['api_secret'];
                $this->livemode = $account_query->row['livemode'];
                $this->merchantID = $account_query->row['merchantID'];
                $this->merchantGUID = $account_query->row['merchantGUID'];
                $this->merchantID_amex = $account_query->row['merchantID_amex'];
                $this->merchantGUID_amex = $account_query->row['merchantGUID_amex'];

                $this->currency->set($this->account_currency);


				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_ip WHERE account_id = '" . $this->db->escape($this->account_id) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "account_ip SET account_id = '" . $this->db->escape($this->session->data['account_id']) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}

			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password, $override = false) {

		if ($override) {
			$account_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($username)) . "' OR username = '" . $this->db->escape(utf8_strtolower($username)) . "' AND status = '1'");
		} else {
			$account_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($username)) . "' OR username = '" . $this->db->escape(utf8_strtolower($username)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}


		if ($account_query->num_rows) {
			$this->session->data['account_id'] = $account_query->row['account_id'];

			$this->account_id = $account_query->row['account_id'];
			$this->account_group_id = $account_query->row['account_group_id'];
			$this->firstname = $account_query->row['firstname'];
			$this->lastname = $account_query->row['lastname'];
			$this->email = $account_query->row['email'];
            $this->account_currency = $account_query->row['currency_code'];
            $this->account_language = $account_query->row['language_code'];
            $this->api_id = $account_query->row['api_id'];
            $this->secret_key = $account_query->row['api_secret'];
            $this->livemode = $account_query->row['livemode'];
            $this->merchantID = $account_query->row['merchantID'];
            $this->merchantGUID = $account_query->row['merchantGUID'];
            $this->merchantID_amex = $account_query->row['merchantID_amex'];
            $this->merchantGUID_amex = $account_query->row['merchantGUID_amex'];

            $this->currency->set($this->account_currency);

			$this->db->query("UPDATE " . DB_PREFIX . "account SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE account_id = '" . $this->db->escape($this->account_id) . "'");

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['account_id']);
        unset($this->session->data['tokenize']);
        unset($this->session->data['token']);

		$this->account_id = '';
		$this->account_group_id = '';
		$this->account_detail_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
        $this->account_currency = '';
        $this->account_language = '';
        $this->api_id = '';
        $this->secret_key = '';
        $this->livemode = '';
        $this->merchantID = '';
        $this->merchantGUID = '';
        $this->merchantID_amex = '';
        $this->merchantGUID_amex = '';
	}

	public function isLogged() {
		return $this->account_id;
	}

	public function getId() {
		return $this->account_id;
	}

	public function getAccountGroupId() {
		return $this->account_group_id;
	}

	public function getAccountDetailId() {
		return $this->account_detail_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getEmail() {
		return $this->email;
	}

    public function getMode() {
        return $this->livemode;
    }

    public function getCurrencyCode() {
        return $this->account_currency;
    }

    public function getLanguageCode() {
        return $this->account_language;
    }

    public function getApiId() {
        return $this->api_id;
    }

    public function getApiSecret() {
        return $this->secret_key;
    }

    public function getMerchantID(){
        return $this->merchantID;
    }

    public function getMerchantGUID(){
        return $this->merchantGUID;
    }

    public function getMerchantIDAMEX(){
        return $this->merchantID_amex;
    }

    public function getMerchantGUIDAMEX(){
        return $this->merchantGUID_amex;
    }

	public function getCards(){
		$query = $this->db->query("SELECT COUNT(card_id) AS total FROM " . DB_PREFIX . "card WHERE account_id = '" . (int) $this->account_id. "'");


		return $query->row['total'];
	}

	public function getBalance() {

		$balance = 0;

		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "transaction WHERE (account_id = '" .  (int) $this->account_id. "' AND status = '1' AND livemode = '".(int) $this->getMode()."') AND (charged = '1' OR captured = '1' OR received = '1' OR sent = '1')");

		$fees = $this->getFees();

		$balance = $query->row['total'] - $fees;
		return $balance;
	}

	public function getFees() {

		$query = $this->db->query("SELECT SUM(fee) AS total FROM " . DB_PREFIX . "transaction WHERE (account_id = '" .  (int) $this->account_id. "' AND status = '1' AND livemode = '".(int) $this->getMode()."') AND (charged = '1' OR captured = '1' OR received = '1' OR sent = '1')");

		return $query->row['total'];
	}
}