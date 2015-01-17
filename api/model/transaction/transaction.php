<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/11/15
 * Time: 10:01 AM
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

class ModelTransactionTransaction extends Model {

	public function addTransaction($account_id , $data){

		$this->db->query("INSERT INTO ".DB_PREFIX."transaction SET
		account_id = '".(int) $account_id."',
		customer_id = '".$this->db->escape($data['customer_id'])."',
		fingerprint = '".$this->db->escape($data['fingerprint'])."',
		card_holder = '".$this->db->escape($data['card_holder'])."',
		card_number = '".$this->db->escape($data['card_number'])."',
		card_type = '".$this->db->escape($data['card_type'])."',
		fee = '".$this->db->escape($data['fee'])."',
		amount = '".$this->db->escape($data['amount'])."',
		customer_ip_address = '".$this->db->escape($data['customer_ip_address'])."',
		status = '".$this->db->escape($data['status'])."',
		refunded = '".($data['refunded'] ? $data['refunded'] : 0)."',
		refunded_date = '".($data['refunded'] ? $data['refund_date'] : null)."',
		captured = '".($data['captured'] ? $data['captured'] : 0)."',
		captured_date = '".($data['captured'] ? $data['capture_date'] : null)."',
		voided = '".($data['voided'] ? $data['voided'] : 0)."',
		voided_date = '".($data['voided'] ? $data['void_date'] : null)."',
		authorized = '".($data['authorized'] ? $data['authorized'] : 0)."',
		authorized_date = '".($data['authorized'] ? $data['authorized_date'] : null)."',
		verified = '".($data['verified'] ? $data['verified'] : 0)."',
		verified_date = '".($data['verified'] ? $data['verified_date'] : null)."',
		charged = '".($data['charged'] ? $data['charged'] : 0)."',
		charged_date = '".($data['charged'] ? $data['charged_date'] : null)."',
		sent = '".($data['sent'] ? $data['sent'] : 0)."',
		sent_date = '".($data['sent'] ? $data['sent_date'] : null)."',
		received = '".($data['received'] ? $data['received'] : 0)."',
		received_date = '".($data['received'] ? $data['received_date'] : null)."',
		withdrawal = '".($data['withdrawal'] ? $data['withdrawal'] : 0)."',
		withdrawal_date = '".($data['withdrawal'] ? $data['withdrawal_date'] : null)."',
		additionalInfo = '".$this->db->escape($data['additionalInfo'])."',
		dynamicDescriptor = '".$this->db->escape($data['dynamicDescriptor'])."',
		livemode = '".$this->account->getMode()."',
		date_added = NOW()");

		return $this->db->getLastId();

	}

	public function updateTransaction($transaction_id,$type){

        $sql = "UPDATE ".DB_PREFIX."transaction SET";

        if ($type == TRX_REFUND){
            $sql .=" refunded = '1', refunded_date = NOW(),captured='0',charged = '0'";
        } elseif ($type == TRX_CAPTURE){
            $sql .=" captured = '1', captured_date = NOW(),authorized = '0',verified='0'";
        } elseif ($type == TRX_VOID){
            $sql .=" voided = '1', voided_date = NOW(),captured='0',charged = '0',authorized = '0',verified='0'";
        }

        $sql .=" WHERE transaction_id ='".(int) $transaction_id."'";

        $this->db->query($sql);

	}

	public function addTransactionLog($data,$type){

		$this->db->query("INSERT INTO ".DB_PREFIX."transaction_log SET
		reference = '".$this->db->escape($data['reference'])."',
		enrollment_id = '".$this->db->escape($data['enrollment_id'])."',
		transaction_type = '".$this->db->escape($data['transaction_type'])."',
		`type` = '".$this->db->escape($type)."',
		transaction_state = '".$this->db->escape($data['transaction_state'])."',
		transaction_code = '".$this->db->escape($data['transaction_code'])."',
		transaction_message = '".$this->db->escape($data['transaction_message'])."',
		transaction_id = '".$this->db->escape($data['transaction_id'])."',
		transaction_guid = '".$this->db->escape($data['transaction_guid'])."',
		transaction_date = '".$this->db->escape($data['transaction_date'])."',
		issuer_url = '".$this->db->escape($data['issuer_url'])."',
		authentication_request = '".$this->db->escape($data['authentication_request'])."',
		tracking_code = '".$this->db->escape($data['tracking_code'])."',
		cdc_data = '".$this->db->escape($data['cdc_data'])."'");

		return $this->db->getLastId();

	}

}
