<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 7:52 PM
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

class ModelSystemAuth extends Model {

	public function doAuthentication($api_id, $api_secret){

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."account WHERE api_id = '".$this->db->escape($api_id)."' AND api_secret = '".$this->db->escape($api_secret)."'");

		if ($query->row){
			return true;
		} else {
			return false;
		}
	}

	public function getAccount($api_id, $api_secret){

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."account WHERE api_id = '".$this->db->escape($api_id)."' AND api_secret = '".$this->db->escape($api_secret)."'");

		return $query->row;
	}
} 