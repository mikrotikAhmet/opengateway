<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 * OGCA
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC..
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * @package     Semite LLC
 * @version     $Id: setting.php Oct 4, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of setting  Class
 *
 * @author ahmet
 */
/*
 * Copyright (C) 2014 ahmet
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ModelOpengatewaySetting extends Model{
    
    public function getAvailableCurrencies(){
        
        $results = $this->db->query("SELECT * FROM ".DB_PREFIX."currency WHERE status = '1'");
        
        return $results->rows;
    }
    
    public function getBankByCurrencyId($currency_id){
        
        $result = $this->db->query("SELECT * FROM ".DB_PREFIX."bank WHERE currency_id = '".(int) $currency_id."'");
        
        return $result->row;
        
    }
    
    public function getCurrency($currency_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int) $currency_id . "'");

        return $query->row;
    }
    
    public function getCountry($country_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int) $country_id . "'");

        return $query->row;
    }
    
    public function getZone($zone_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int) $zone_id . "'");

        return $query->row;
    }
    
    public function getStatus($status_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "status WHERE status_id = '" . (int) $status_id . "' AND language_id = '".(int) $this->config->get('config_language_id')."'");

        return $query->row;
    }
    
    public function updateCurrencies($force = false) {
        if (extension_loaded('curl')) {
            $data = array();

            if ($force) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "'");
            } else {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "' AND date_modified < '" . $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'");
            }

            foreach ($query->rows as $result) {
                $data[] = $this->config->get('config_currency') . $result['code'] . '=X';
            }

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $data) . '&f=sl1&e=.csv');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);

            $content = curl_exec($curl);

            curl_close($curl);

            $lines = explode("\n", trim($content));

            foreach ($lines as $line) {
                $currency = utf8_substr($line, 4, 3);
                $value = utf8_substr($line, 11, 6);

                if ((float) $value) {
                    $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . (float) $value . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($currency) . "'");
                }
            }

            $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($this->config->get('config_currency')) . "'");

            $this->cache->delete('currency');
        }
    }
}

