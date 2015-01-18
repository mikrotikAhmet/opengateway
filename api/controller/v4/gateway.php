<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/18/15
 * Time: 9:19 AM
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

class ControllerV4Gateway extends Controller {

	private $params = array();

	public function Authentication(){

		$this->load->model('system/auth');

		// grab the request
		$request = trim(file_get_contents('php://input'));

		// find out if the request is valid XML
		$xml = @simplexml_load_string($request);

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			// if it is not valid XML...
			if (!$xml) {

				$params = $this->request->post;

			} else {

				// Make an array out of the XML
				$this->load->library('arraytoxml');
				$params = $this->arraytoxml->toArray($xml);
			}

			// Start validation
			$this->validateAuthentication($params['authentication']['api_id'],$params['authentication']['secret_key']);
		}

		$this->_api->processApi($this->params, 4006);
	}

	public function Payment(){

		// grab the request
		$request = trim(file_get_contents('php://input'));

		// find out if the request is valid XML
		$xml = @simplexml_load_string($request);

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			// if it is not valid XML...
			if (!$xml) {

				$params = $this->request->post;

			} else {

				// Make an array out of the XML
				$this->load->library('arraytoxml');
				$params = $this->arraytoxml->toArray($xml);
			}

			// Start validation
			$auth = $this->validateAuthentication($params['authentication']['api_id'],$params['authentication']['secret_key']);

			if ($auth){

				$this->load->model('system/auth');
				$this->load->model('localisation/country');

				$account_info = $this->model_system_auth->getAccount($params['authentication']['api_id'],$params['authentication']['secret_key']);
				$country_info = $this->model_localisation_country->getCountry($account_info['country_id']);
			}

			$ip = $this->request->server['REMOTE_ADDR'];
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$forwarded_ip = $this->request->server['HTTP_X_FORWARDED_FOR'];
			} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$forwarded_ip = $this->request->server['HTTP_CLIENT_IP'];
			} else {
				$forwarded_ip = '';
			}
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$user_agent = $this->request->server['HTTP_USER_AGENT'];
			} else {
				$user_agent = '';
			}
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$accept_language = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
			} else {
				$accept_language = '';
			}

			try {
				$client = new Payvision_Client(Payvision_Client::ENV_TEST);

				$operation = new Payvision_BasicOperations_Payment();
				$operation->setMember($account_info['merchantID'], $account_info['merchantGUID']);
				$operation->setCountryId(Payvision_Translator::getCountryIdFromIso($country_info['iso_code_3']));

				$operation->setCardNumberAndHolder($params['credit_card']['card_num'],(isset($card_holder) ? $card_holder : null));
				$operation->setCardExpiry($params['credit_card']['exp_month'], $params['credit_card']['exp_year']);
				$operation->setCardValidationCode($params['credit_card']['cvv']);

				$operation->setAmountAndCurrencyId((float) $params['amount'], Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

				$operation->setTrackingMemberCode(TRX_CHARGE.' ' . date('His dmY'));


				// avsAddress
				$operation->setAvsAddress($account_info['address_1'].' '.$account_info['address_2'], (!empty($account_info['postal_code']) ? $account_info['postal_code'] : $account_info['telephone']));

				$operation->setDynamicDescriptor($account_info['dynamicDescriptor'].'|'.$account_info['telephone']);

				if (isset($params['merchantType'])){
					$operation->setMerchantType($params['merchantType']);
				}

				$client->call($operation);

				var_dump(
					$operation->getResultState(),
					$operation->getResultCode(),
					$operation->getResultMessage(),
					$operation->getResultTransactionId(),
					$operation->getResultTransactionGuid(),
					$operation->getResultTransactionDateTime(),
					$operation->getResultTrackingMemberCode(),
					$operation->getResultCdcData()
				);

				$this->_api->processApi($this->params, 2000);

			} catch (Payvision_Exception $e) {

				$this->params['error'] = $e->getMessage();

				$this->_api->processApi($this->params, 5008);
			}
		}

		$this->_api->processApi($this->params, 4006);
	}

	protected function validateAuthentication($api_id,$api_secret){

		$this->load->model('system/auth');

		$auth = $this->model_system_auth->doAuthentication($api_id,$api_secret);

		if (!$auth) {

			$this->_api->processApi($this->params, 5001);
		}

		return !$this->error;
	}
} 