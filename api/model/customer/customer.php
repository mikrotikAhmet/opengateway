<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/11/15
 * Time: 10:13 AM
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

class ModelCustomerCustomer extends Model {

    public function editCustomer($customer_id,$data){

        $this->db->query("UPDATE ".DB_PREFIX."customer SET
		firstname = '".$this->db->escape($data->firstname)."',
		lastname = '".$this->db->escape($data->lastname)."',
		company = '".$this->db->escape($data->company)."',
		address_1 = '".$this->db->escape($data->address_1)."',
		address_2 = '".$this->db->escape($data->address_2)."',
		country_id = '".(int) $data->country_id."',
		city = '".$this->db->escape($data->city)."',
		zone_id = '".(int) $data->zone_id."',
		postcode = '".$this->db->escape($data->postcode)."',
		telephone = '".$this->db->escape($data->telephone)."'
		WHERE customer_id = '".$this->db->escape($customer_id)."'");

    }

	public function newCustomer($account_id,$data){

		$this->load->helper('random_id');

		$customer_id = CUSTOMER_PREFIX.generate_id('random',15);

		$this->db->query("INSERT INTO ".DB_PREFIX."customer SET
		customer_id = '".$this->db->escape($customer_id)."',
		account_id = '".(int) $account_id."',
		firstname = '".$this->db->escape($data->firstname)."',
		lastname = '".$this->db->escape($data->lastname)."',
		company = '".$this->db->escape($data->company)."',
		address_1 = '".$this->db->escape($data->address_1)."',
		address_2 = '".$this->db->escape($data->address_2)."',
		country_id = '".(int) $data->country_id."',
		city = '".$this->db->escape($data->city)."',
		zone_id = '".(int) $data->zone_id."',
		postcode = '".$this->db->escape($data->postcode)."',
		telephone = '".$this->db->escape($data->telephone)."',
		email = '".$this->db->escape($data->email)."',
		date_added = NOW()");

		return $customer_id;
	}

	public function addCustomer($account_id,$data){

		$this->load->helper('random_id');

		$customer_id = CUSTOMER_PREFIX.generate_id('random',15);

		$this->db->query("INSERT INTO ".DB_PREFIX."customer SET
		customer_id = '".$this->db->escape($customer_id)."',
		account_id = '".(int) $account_id."',
		firstname = '".$this->db->escape($data['firstname'])."',
		lastname = '".$this->db->escape($data['lastname'])."',
		company = '".$this->db->escape($data['company'])."',
		address_1 = '".$this->db->escape($data['address_1'])."',
		address_2 = '".$this->db->escape($data['address_2'])."',
		country_id = '".(int) $data['country_id']."',
		city = '".$this->db->escape($data['city'])."',
		zone_id = '".(int) $data['zone_id']."',
		postcode = '".$this->db->escape($data['postal_code'])."',
		telephone = '".$this->db->escape($data['telephone'])."',
		email = '".$this->db->escape($data['email'])."',
		date_added = NOW()");

		return $customer_id;
	}

	public function getCustomer($customer_id){

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer WHERE customer_id = '".$this->db->escape($customer_id)."'");

		return $query->row;
	}

    public function getCustomers($account_id,$data = array()) {
        $sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "customer WHERE account_id = '".(int) $account_id."'";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if ($implode) {
            $sql .= " AND " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'email',
            'date_added'
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

    public function getTotalCustomers($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }


        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getCustomerByEmail($email){

        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer WHERE LCASE(email) = '".$this->db->escape($email)."'");

        return $query->row;
    }
} 