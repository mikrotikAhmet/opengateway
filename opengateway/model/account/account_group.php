<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/3/15
 * Time: 1:55 PM
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
	public function addAccountGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "account_group SET personal = '" . (int)$data['personal'] . "',business = '" . (int)$data['business'] . "',business_contact = '" . (int)$data['business_contact'] . "',approval = '" . (int)$data['approval'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$account_group_id = $this->db->getLastId();

		foreach ($data['account_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "account_group_description SET account_group_id = '" . (int)$account_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}

	public function editAccountGroup($account_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "account_group SET   personal = '" . (int)$data['personal'] . "',business = '" . (int)$data['business'] . "',business_contact = '" . (int)$data['business_contact'] . "',approval = '" . (int)$data['approval'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE account_group_id = '" . (int)$account_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "account_group_description WHERE account_group_id = '" . (int)$account_group_id . "'");

		foreach ($data['account_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "account_group_description SET account_group_id = '" . (int)$account_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}

	public function deleteAccountGroup($account_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "account_group WHERE account_group_id = '" . (int)$account_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "account_group_description WHERE account_group_id = '" . (int)$account_group_id . "'");
	}

	public function getAccountGroup($account_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "account_group cg LEFT JOIN " . DB_PREFIX . "account_group_description cgd ON (cg.account_group_id = cgd.account_group_id) WHERE cg.account_group_id = '" . (int)$account_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAccountGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "account_group cg LEFT JOIN " . DB_PREFIX . "account_group_description cgd ON (cg.account_group_id = cgd.account_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'cgd.name',
			'cg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cgd.name";
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

	public function getAccountGroupDescriptions($account_group_id) {
		$account_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "account_group_description WHERE account_group_id = '" . (int)$account_group_id . "'");

		foreach ($query->rows as $result) {
			$account_group_data[$result['language_id']] = array(
				'name'        => $result['name'],
				'description' => $result['description']
			);
		}

		return $account_group_data;
	}

	public function getTotalAccountGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "account_group");

		return $query->row['total'];
	}
} 