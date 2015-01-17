<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/11/15
 * Time: 4:00 PM
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

class ControllerApiCommon extends Controller {

	public function refund(){

		$params = $this->request->post;

		sleep(1);

		$url = "http://api.semite.com/v1/gateway/Refund";

		$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<type>Refund</type>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<transaction_id>'.$params['transaction_id'].'</transaction_id>
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

    public function capture(){

        $params = $this->request->post;


        $url = "http://api.semite.com/v1/gateway/Capture";

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<type>Capture</type>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<transaction_id>'.$params['transaction_id'].'</transaction_id>
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

    public function void(){

        $params = $this->request->post;

        sleep(1);

        $url = "http://api.semite.com/v1/gateway/Void";

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<type>Void</type>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<transaction_id>'.$params['transaction_id'].'</transaction_id>
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