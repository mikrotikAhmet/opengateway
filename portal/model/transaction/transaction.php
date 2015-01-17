<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2008 - 2015, Semite LLC.
 * @license		http://www.semitellc.com/user_guide/license.html
 * @link		http://www.semitellc.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * semite.com
 * Description of transaction.php Class
**/


class ModelTransactionTransaction extends Model {

    public function getTransaction3DSLog($enrollment_id){

        $sql = "SELECT * FROM ".DB_PREFIX."transaction_log WHERE enrollment_id = '".(int) $enrollment_id."'";

        $query = $this->db->query($sql);

        return $query->row;
    }

	public function getTransaction($account_id,$transaction_id){

		$query  = $this->db->query("SELECT * FROM ".DB_PREFIX."transaction WHERE account_id = '".(int) $account_id."' AND transaction_id = '".(int) $transaction_id."'");

		return $query->row;
	}

} 