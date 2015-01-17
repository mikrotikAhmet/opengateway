<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 8:02 PM
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

class ModelReportTransaction extends Model {

	public function getTransaction($account_id,$transaction_id){

		$query  = $this->db->query("SELECT * FROM ".DB_PREFIX."transaction WHERE account_id = '".(int) $account_id."' AND transaction_id = '".(int) $transaction_id."'");

		return $query->row;
	}

    public function getTransactionByReference($account_id,$transaction_id){

        $query  = $this->db->query("SELECT * FROM ".DB_PREFIX."transaction_log WHERE account_id = '".(int) $account_id."' AND reference = '".(int) $transaction_id."'");

        return $query->row;
    }

	public function getTransactions($account_id,$data = array()){

		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` WHERE account_id = '" . (int) $account_id."'";

		$sort_data = array(
			'amount',
			'date_added'
		);

		if (isset($data['filter_date_start']) && isset($data['filter_date_end'])){
			$sql .= " AND date_added BETWEEN DATE('".$this->db->escape($data['filter_date_start'])." 00:00:00') AND DATE('".$this->db->escape($data['filter_date_end'])." 23:59:00')";
		}


		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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


		$transaction_data = $this->db->query($sql);

		return $transaction_data->rows;

	}

	public function getTotalTransactions($account_id,$data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE account_id = '" . (int) $account_id. "'";

		$sort_data = array(
			'amount',
			'date_added'
		);

		if (isset($data['filter_date_start']) && isset($data['filter_date_end'])){
			$sql .= " AND date_added BETWEEN DATE('".$this->db->escape($data['filter_date_start'])."') AND DATE('".$this->db->escape($data['filter_date_end'])."')";
		}


		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}


		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTransactionLog($transaction_id,$type = null){

        $sql = "SELECT * FROM ".DB_PREFIX."transaction_log WHERE reference = '".(int) $transaction_id."' AND transaction_id <> '0'";

		if (isset($type)){
            $sql .=" AND `type` = '".$this->db->escape($type)."'";
        }

        $query = $this->db->query($sql);

		return $query->row;
	}
} 