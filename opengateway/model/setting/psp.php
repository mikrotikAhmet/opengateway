<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/26/14
 * Time: 4:27 PM
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

class ModelSettingPsp extends Model {
	public function addPsp($data) {
		$this->event->trigger('pre.admin.add.psp', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "psp SET name = '" . $this->db->escape($data['name']) . "',memberId = '" . (int) $data['memberId'] . "',memberGuid = '" . $this->db->escape($data['memberGuid']) . "', avsAddress = '".(int) $data['avsAddress']."', dynamicDescriptor = '".(int) $data['dynamicDescriptor']."', status = '".(int) $data['status']."'");

		$psp_id = $this->db->getLastId();

		$this->cache->delete('psp');

		$this->event->trigger('post.admin.add.psp', $psp_id);

		return $psp_id;
	}

	public function editPsp($psp_id, $data) {
		$this->event->trigger('pre.admin.edit.psp', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "psp SET name = '" . $this->db->escape($data['name']) . "',memberId = '" . (int) $data['memberId'] . "',memberGuid = '" . $this->db->escape($data['memberGuid']) . "', avsAddress = '".(int) $data['avsAddress']."', dynamicDescriptor = '".(int) $data['dynamicDescriptor']."', status = '".(int) $data['status']."' WHERE psp_id = '" . (int)$psp_id . "'");

		$this->cache->delete('psp');

		$this->event->trigger('post.admin.edit.psp');
	}

	public function deletePsp($psp_id) {
		$this->event->trigger('pre.admin.delete.psp', $psp_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

		$this->cache->delete('psp');

		$this->event->trigger('post.admin.delete.psp', $psp_id);
	}

	public function getPsp($psp_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

		return $query->row;
	}

	public function getPsps($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "psp";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
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

	public function getTotalPsps() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "psp");

		return $query->row['total'];
	}
}