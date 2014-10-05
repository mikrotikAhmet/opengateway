<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC.
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * OGCA - Open Gateway Core Application
 * Description of api.php Class
 * */
class Api {

    private $merchant;
    private $api_key;
    private $customer_id;
    private $end_point = "http://lapi.semitepayment.com/";

    public function __construct($registry) {
        
    }

    public function apiGet($api_func) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->end_point . $api_func . "&merchant_id=" . $this->merchant . "&api_key=" . $this->api_key . "&customer_id=" . $this->getCustomerId());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2); //only 2 redirects
//  curl_setopt($ch,CURLOPT_HEADER, false); 

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public function apiPost($api_func, $params) {
$postData = '';
        //create name value pairs seperated by &
        foreach ($params as $k => $v) {
            $postData .= $k . '=' . $v . '&';
        }
        rtrim($postData, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->end_point . $api_func . "&merchant_id=" . $this->merchant . "&api_key=" . $this->api_key . "&customer_id=" . $this->getCustomerId());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2); //only 2 redirects
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public function apiPut() {
        
    }

    public function apiDelete() {
        
    }

    public function setMerchant($merchant) {

        $this->merchant = $merchant;
    }

    public function getMerchant() {
        return $this->merchant;
    }

    public function setApiKey($api_key) {

        $this->api_key = $api_key;
    }

    public function getApiKey() {
        return $this->api_key;
    }

    public function setCustomerId($customer_id) {
        $this->customer_id = $customer_id;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

}