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
 * semite.com
 * Description of success.php Class
**/


class ControllerCommonMPISuccess extends Controller {


    public function index(){

        $enrollmentId = $this->request->get['enrollmentId'];
        $securityCode = $this->request->get['securityCode'];


        $this->load->model('transaction/transaction');

        $transaction_log = $this->model_transaction_transaction->getTransaction3DSLog($enrollmentId);

        $url = "http://api.semitepayment.com/v3/gateway/doPayment";

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<type>Charge</type>
	<securityCode>'.$securityCode.'</securityCode>
	<memberTrackingCode>'.$transaction_log['tracking_code'].'</memberTrackingCode>
	<paResult>'.$_POST['PaRes'].'</paResult>
	<enrollmentId>'.$enrollmentId.'</enrollmentId>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
</request>';

        $postfields = $post_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


        $data = curl_exec($ch);

        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        else
        {
            curl_close($ch);
            echo $data;
        }

    }
} 