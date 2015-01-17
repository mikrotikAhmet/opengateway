<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/16/15
 * Time: 11:05 PM
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

class ModelAccountCard extends Model {

	public function addCard($account_id ,$data){

		$this->load->helper('random_id');

		$card_id = CARD_PREFIX.generate_id('random',9);

		$this->db->query("INSERT INTO ".DB_PREFIX."card SET card_id = '".$this->db->escape($card_id)."',
        account_id = '".$this->db->escape($account_id)."',
        card_num = '".$this->db->escape($data['card_num'])."',
        expire_date = '".$this->db->escape($data['expire_date'])."',
        cvv = '".$this->db->escape($data['cvv'])."',
        fingerprint = '".$this->db->escape($data['fingerprint'])."',
        `type` = '".$this->db->escape($data['type'])."'");
	}

	public function updateToken($token,$card){

		$this->db->query('UPDATE '.DB_PREFIX."card SET token = '".$this->db->escape($token)."' WHERE card_id = '".$this->db->escape($card)."'");
	}

	public function verifyCard($card){

		$this->db->query('UPDATE '.DB_PREFIX."card SET token = '', verified = '1' WHERE card_id = '".$this->db->escape($card)."'");
	}

} 