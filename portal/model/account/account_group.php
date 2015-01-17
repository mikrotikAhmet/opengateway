<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/3/15
 * Time: 3:06 PM
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

class ModelAccountAccountGroup extends Model {
	public function getAccountGroup($account_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account_group cg LEFT JOIN " . DB_PREFIX . "account_group_description cgd ON (cg.account_group_id = cgd.account_group_id) WHERE cg.account_group_id = '" . (int)$account_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAccountGroups() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_group cg LEFT JOIN " . DB_PREFIX . "account_group_description cgd ON (cg.account_group_id = cgd.account_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cg.sort_order ASC, cgd.name ASC");

		return $query->rows;
	}
}