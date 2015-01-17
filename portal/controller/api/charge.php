<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 11:23 PM
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

class ControllerApiCharge extends Controller {


    public function charge(){

        $params = $this->request->post;

        $url = "http://".API_BASE."/v1/gateway/Charge";

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>Charge</request>
	<customer_id>'.($params['customer_id'] ? $params['customer_id'] : 0).'</customer_id>
	<credit_card>
		<card_num>'.$params['card_num'].'</card_num>
		<exp_month>'.$params['exp_month'].'</exp_month>
		<exp_year>'.$params['exp_year'].'</exp_year>
		<cvv>'.$params['cvv'].'</cvv>
	</credit_card>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<amount>'.$params['amount'].'</amount>';

        if (isset($params['customer'])){
            $post_string .= '<customer>
	<firstname>'.$params['customer']['firstname'].'</firstname>
	<lastname>'.$params['customer']['lastname'].'</lastname>
	<company>'.$params['customer']['company'].'</company>
	<address_1>'.$params['customer']['address_1'].'</address_1>
	<address_2>'.$params['customer']['address_2'].'</address_2>
	<country_id>'.$params['customer']['country_id'].'</country_id>
	<city>'.$params['customer']['city'].'</city>
	<zone_id>'.$params['customer']['zone_id'].'</zone_id>
	<postal_code>'.$params['customer']['postcode'].'</postal_code>
	<telephone>'.$params['customer']['telephone'].'</telephone>
	<email>'.$params['customer']['email'].'</email>
</customer>
	<merchantType>1</merchantType>
<additionalInfo>'.serialize($params['additionalInfo']).'</additionalInfo>';
        }

        $post_string .='</request>';

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

	public function deposit(){

		$params = $this->request->post;

		$this->load->model('gateway/card');

		$card_info = $this->model_gateway_card->getCard($params['card_id']);
		$exp_date = explode('-',$card_info['expire_date']);

		$url = "http://".API_BASE."/v1/gateway/Deposit";

		$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>Deposit</request>
<credit_card>
	    <card_holder>'.$this->account->getFirstName().' '.$this->account->getLastName().'</card_holder>
		<card_num>'.$this->encryption->decrypt($card_info['fingerprint']).'</card_num>
		<exp_month>'.$exp_date[0].'</exp_month>
		<exp_year>'.$exp_date[1].'</exp_year>
		<cvv>'.$card_info['cvv'].'</cvv>
	</credit_card>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
	<merchantType>1</merchantType>
	<additionalInfo>
	</additionalInfo>
	<amount>'.$params['amount'].'</amount>
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