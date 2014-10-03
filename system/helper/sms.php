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
 * Description of sms.php Class
**/


class Sms {

    private $user = 'xxxxx'; // Your user id
    private $password = 'xxxxxxx'; // Your password
    private $api_id = 'xxxxxx'; // Your api id
    private $end_point = 'http://api.clickatell.com';
    private $message;
    private $mobile;
    private $url;
    private $auth;
    private $authentication = false;
    private $session;

    public function __construct(){

        $this->url = $this->end_point.'http/auth?user='.$this->user.'&password='.$this->password.'&api_id='.$this->api_id;

    }

    public function setMobile($mobile){
        $this->mobile = $mobile;
    }

    public function getMobile(){

        return $this->mobile;
    }

    public function setMessage($message){

        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }

    public function doAuth(){

        $this->auth = file($this->url);

        $this->session = explode(":", $this->auth[0]);

        if ($this->session[0] == "OK"){
            $this->authentication = true;
        } else {
            $this->authentication = false;
        }
    }

    public function sendSms(){

        $authentication = $this->doAuth();

        if ($authentication){

            $session_id = trim($this->session[1]);
            $url = $this->end_point.'/http/sendmsg?session_id='.$session_id.'&to='.$this->getMobile().'&text='.$this->getMessage();

            $ret = file($url);

            $send = explode(":",$ret[0]);

            if ($send[0] == "ID"){
                return true;
            } else {
                return false;
            }
        }

    }


} 