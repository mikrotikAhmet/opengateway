<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/4/15
 * Time: 9:27 PM
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

class ModelGatewayBank extends Model {

	public function getBank($bank_code){

		$query = $this->db->query("SELECT DISTINCT *,(c.name) AS country,(z.name) AS `city`,(b.code) AS code FROM " . DB_PREFIX . "bank b LEFT JOIN ".DB_PREFIX."country c ON(b.country_id = c.country_id) LEFT JOIN ".DB_PREFIX."zone z ON(b.zone_id = z.zone_id) WHERE b.code = '" . $this->db->escape($bank_code) . "'");

		return $query->row;
	}
} 