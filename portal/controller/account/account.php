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
 * Description of account.php Class
**/


class ControllerAccountAccount extends Controller {

    private $error = array();

    public function addCard(){

        $url = "http://api.semite.com/v1/account/addCard";

        // XML Request

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>addCard</request>
	<account_id>'.$this->account->getId().'</account_id>
	<credit_card>
		<card_num>'.str_replace("-","",$this->request->post['card_num']).'</card_num>
		<exp_month>'.$this->request->post['month'].'</exp_month>
		<exp_year>'.$this->request->post['year'].'</exp_year>
		<cvv>'.$this->request->post['cvv'].'</cvv>
	</credit_card>
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
	public function cardVerification(){

		$data = $this->request->post;

		$this->load->model('gateway/card');

		$card_info = $this->model_gateway_card->getCard($data['card']);

		$exp_date = explode('-',$card_info['expire_date']);

		$amount = mt_rand (1*10, 10*10) / 10;

		$url = "http://api.semite.com/v1/gateway/Verification";

		// XML Request

		$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>Verification</request>
	<card_id>'.$data['card'].'</card_id>
	<credit_card>
	<card_holder>'.$this->account->getFirstName().' '.$this->account->getLastName().'</card_holder>
		<card_num>'.$this->encryption->decrypt($card_info['fingerprint']).'</card_num>
		<exp_month>'.$exp_date[0].'</exp_month>
		<exp_year>'.$exp_date[1].'</exp_year>
		<cvv>'.$card_info['cvv'].'</cvv>
		<verified>'.$card_info['verified'].'</verified>
	</credit_card>
	<amount>'.(float) $amount.'</amount>
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

	public function doVerification(){

		$json = array();

		$this->load->model('gateway/card');

		$card_info = $this->model_gateway_card->getCard($this->request->post['verification_card_id']);

		$get_trx_id = explode('-',$this->encryption->decrypt($card_info['token']));

		if ($this->request->post['code'].'-'.$get_trx_id[1] != $this->encryption->decrypt($card_info['token'])){

			$json = array(
				'status'=>'Card information error.',
			);


			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));

		} else {

			$data = $this->request->post;

			$this->load->model('transaction/transaction');

			$transaction_info = $this->model_transaction_transaction->getTransaction($this->account->getId(),$get_trx_id[1]);

			$url = "http://api.semite.com/v1/gateway/Capture";

			// XML Request

			$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>Capture</request>
    <card_id>'.$card_info['card_id'].'</card_id>
	<transaction_id>'.$transaction_info['transaction_id'].'</transaction_id>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
</request>';

			$postfields = $post_string;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 200);
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

	public function sendMoney(){

		$json = array();

		$data = $this->request->post;

		$this->load->model('account/account');

		$account_info = $this->model_account_account->getAccountByEmail($data['email']);

		if (!$account_info) {
			$json = array(
				'status' => 'Recipient email could not be found on system!'
			);

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		} elseif (!$data['amount']) {
			$json = array(
				'status' => 'Please enter valid amount'
			);

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		} elseif ($data['amount'] > $this->account->getBalance()) {
			$json = array(
				'status' => 'Insufficient balance.'
			);

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));

		} else {

			$url = "http://api.semite.com/v1/gateway/Send";

			// XML Request

			$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>Send</request>
	<account_id>'.$this->account->getId().'</account_id>
    <recipient_id>'.$account_info['account_id'].'</recipient_id>
	<amount>'.(float) $data['amount'].'</amount>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<additionalInfo>
	    <description>'.$data['description'].'</description>
	</additionalInfo>
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
} 