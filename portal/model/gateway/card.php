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
 * opengateway
 * Description of card.php Class
**/


class ModelGatewayCard extends Model {

	public function getCard($card_id){

		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."card WHERE card_id = '".$this->db->escape($card_id)."'");

		return $query->row;
	}

    public function getCards(){

        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."card WHERE account_id = '".$this->db->escape($this->account->getId())."'");

        return $query->rows;
    }

    public function updateToken($token,$card){

        $this->db->query('UPDATE '.DB_PREFIX."card SET token = '".$this->db->escape($token)."' WHERE card_id = '".$this->db->escape($card)."'");
    }

    public function verifyCard($card){

        $this->db->query('UPDATE '.DB_PREFIX."card SET token = '', verified = '1' WHERE card_id = '".$this->db->escape($card)."'");
    }
} 