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
 * Description of gateway.php Class
**/


class ControllerV1Gateway extends Controller {

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

	public function Charge(){

		// grab the request
		$request = trim(file_get_contents('php://input'));

		// find out if the request is valid XML
		$xml = @simplexml_load_string($request);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCharge($xml)) {

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

				$charge = new Payvision_BasicOperations_Payment();
				$charge->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
				$charge->setCountryId(Payvision_Translator::getCountryIdFromIso($country_info['iso_code_3']));

				$charge->setCardNumberAndHolder($params['credit_card']['card_num'],(isset($params['credit_card']['card_holder']) ? $params['credit_card']['card_holder'] : null));
				$charge->setCardExpiry($params['credit_card']['exp_month'], $params['credit_card']['exp_year']);
				$charge->setCardValidationCode($params['credit_card']['cvv']);

				$charge->setAmountAndCurrencyId((float) $params['amount'], Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

				$charge->setTrackingMemberCode(TRX_CHARGE.' ' . date('His dmY'));


                // avsAddress
                    $charge->setAvsAddress($account_info['address_1'].' '.$account_info['address_2'], (!empty($account_info['postal_code']) ? $account_info['postal_code'] : $account_info['telephone']));

				// add customer
				$this->load->model('customer/customer');

                $customer_id = '';

                if (!$params['customer_id']) {

                    $customer_data = $params['customer'];

                    $customer_info = $this->model_customer_customer->getCustomerByEmail($customer_data['email']);

                    if ($customer_info) {

                            $customer_id = $customer_info['customer_id'];

                        } else {

                            $customer_id = $this->model_customer_customer->addCustomer($account_info['account_id'], $customer_data);
                        }
                } else {

                        $customer_id = $params['customer_id'];
                    }


                // dynamicDecriptor for Semite Payment
				    if (isset($params['dynamicDescriptor']) && empty($params['dynamicDescriptor'])) {
                            $charge->setDynamicDescriptor($params['dynamicDescriptor']);
				    }

                $client->call($charge);

				// do transaction

				// get card information
				$card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);

				if (!$card_status){
					$this->_api->processApi($this->params, 5007);
				}

				$card_info = $this->_validateCard->GetCardInfo();

				$this->params['transaction'] = array(
					'account_id'=>$account_info['account_id'],
					'customer_id'=>$customer_id,
					'subscription_id'=>0,
					'fingerprint'=>$this->encryption->encrypt($params['credit_card']['card_num']),
					'card_number'=>$card_info['substring'],
					'card_type'=>$card_info['type'],
					'fee'=>0,
					'amount'=>$params['amount'],
					'coupon_id'=>0,
					'customer_ip_address'=>$params['customer_ip_address'],
					'status'=>$charge->getResultState(),
					'refunded'=>0,
					'refunded_date'=>0,
					'captured'=>0,
					'captured_date'=>0,
					'voided'=>0,
					'voided_date'=>0,
					'authorized'=>0,
					'authorized_date'=>0,
					'sent'=>0,
					'sent_date'=>0,
					'received'=>0,
					'received_date'=>0,
					'withdrawal'=>0,
					'withdrawal_date'=>0,
					'charged'=>1,
					'charged_date'=>date('Y-m-d H:s:i'),
                    'dynamicDescriptor'=>(isset($params['dynamicDescriptor']) ? $params['dynamicDescriptor'] : null),
					'description'=>(isset($params['customer']) ? $params['description'] : $params['description'])
				);


				// Add transaction
				$this->load->model('transaction/transaction');

				$transaction_id = $this->model_transaction_transaction->addTransaction($account_info['account_id'], $this->params['transaction']);

				$this->params['transactionLog'] = array(
					'reference'=>$transaction_id,
                    'enrollment_id'=>0,
					'transaction_state'=>$charge->getResultState(),
					'transaction_code'=>$charge->getResultCode(),
					'transaction_message'=>$charge->getResultMessage(),
					'transaction_id'=>$charge->getResultTransactionId(),
					'transaction_guid'=>$charge->getResultTransactionGuid(),
					'transaction_date'=>$charge->getResultTransactionDateTime(),
					'tracking_code'=>$charge->getResultTrackingMemberCode(),
                    'issuer_url'=>null,
                    'authentication_request'=>null,
                    'transaction_type'=>TRX_NORMAL,
					'cdc_data'=>serialize($charge->getResultCdcData())
				);

				$this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_CHARGE);



				$this->params['activityLog'] = array(
					'account_id'=>$account_info['account_id'],
					'key'=>TRX_CHARGE,
					'data'=>array(
                        'customer_id'=>$customer_id,
                        'amount'=>$params['amount'],
                        'description'=>(isset($params['customer']) ? $params['description'] : $params['description']),
                        'charged_date'=>date('Y-m-d H:s:i'),
                        'customer_ip_address'=>$params['customer_ip_address']

                    ),
					'ip'=>$_SERVER['REMOTE_ADDR'],
				);

				// Add to activity log
				$this->load->model('account/activity');

				$this->model_account_activity->addActivity(TRX_CHARGE, $this->params['activityLog']);





				$this->params['transaction_id'] = $transaction_id;
				$this->_api->processApi($this->params, 2000);
			}
			catch (Payvision_Exception $e)
			{

				$this->params['error'] = $e->getMessage();

				$this->_api->processApi($this->params, 5008);
			}

		}

		$this->_api->processApi($this->params, 2000);
	}

	public function Refund(){
		// grab the request
		$request = trim(file_get_contents('php://input'));

		// find out if the request is valid XML
		$xml = @simplexml_load_string($request);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRefund($xml)) {

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

			$this->load->model('report/transaction');

			$transaction = $this->model_report_transaction->getTransaction($account_info['account_id'],$params['transaction_id']);
			$transaction_log = $this->model_report_transaction->getTransactionLog($params['transaction_id'],TRX_CHARGE);


			try {

				$client = new Payvision_Client(Payvision_Client::ENV_TEST);

				$refund = new Payvision_BasicOperations_Refund();
				$refund->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
				$refund->setTransactionIdAndGuid($transaction_log['transaction_id'], $transaction_log['transaction_guid']);

				$refund->setAmountAndCurrencyId((float) $transaction['amount'], Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

				$refund->setTrackingMemberCode(TRX_REFUND.' ' . date('His dmY'));

				$client->call($refund);

				// Update transaction
				$this->load->model('transaction/transaction');

				if ($refund->getResultState()) {

					$this->model_transaction_transaction->updateTransaction($transaction['transaction_id'],TRX_REFUND);
				}

				$this->params['transactionLog'] = array(
					'reference'=>$params['transaction_id'],
					'transaction_state'=>$refund->getResultState(),
					'transaction_code'=>$refund->getResultCode(),
					'transaction_message'=>$refund->getResultMessage(),
					'transaction_id'=>$refund->getResultTransactionId(),
					'transaction_guid'=>$refund->getResultTransactionGuid(),
					'transaction_date'=>$refund->getResultTransactionDateTime(),
					'tracking_code'=>$refund->getResultTrackingMemberCode(),
                    'enrollment_id'=>0,
                    'issuer_url'=>null,
                    'authentication_request'=>null,
                    'transaction_type'=>TRX_NORMAL,
					'cdc_data'=>serialize($refund->getResultCdcData())
				);

				$this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_REFUND);



                $this->params['activityLog'] = array(
                    'account_id'=>$account_info['account_id'],
                    'key'=>TRX_REFUND,
                    'data'=>array(
                        'reference'=>$params['transaction_id'],
                        'tracking_code'=>$refund->getResultTrackingMemberCode(),
                    ),
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                );

                // Add to activity log
                $this->load->model('account/activity');

                $this->model_account_activity->addActivity(TRX_REFUND, $this->params['activityLog']);


				$this->params['transaction_id'] = $params['transaction_id'];


				$this->_api->processApi($this->params, 2000);
			}
			catch (Payvision_Exception $e)
			{

				$this->params['error'] = $e->getMessage();

				$this->_api->processApi($this->params, 5026);
			}
		}

		$this->_api->processApi($this->params, 4006);
	}

    public function Authorize(){

        // grab the request
        $request = trim(file_get_contents('php://input'));

        // find out if the request is valid XML
        $xml = @simplexml_load_string($request);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAuthorize($xml)) {

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

                $authorize = new Payvision_BasicOperations_Authorize();
                $authorize->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
                $authorize->setCountryId(Payvision_Translator::getCountryIdFromIso($country_info['iso_code_3']));

                $authorize->setCardNumberAndHolder($params['credit_card']['card_num'],(isset($params['credit_card']['card_holder']) ? $params['credit_card']['card_holder'] : null));
                $authorize->setCardExpiry($params['credit_card']['exp_month'], $params['credit_card']['exp_year']);
                $authorize->setCardValidationCode($params['credit_card']['cvv']);

                $authorize->setAmountAndCurrencyId((float) $params['amount'], Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

                $authorize->setTrackingMemberCode(TRX_AUTHORIZE.' ' . date('His dmY'));

                $authorize->setMerchantType($params['merchantType']);

                // avsAddress
                $authorize->setAvsAddress($account_info['address_1'].' '.$account_info['address_2'], (!empty($account_info['postal_code']) ? $account_info['postal_code'] : $account_info['telephone']));


                // add customer
                $this->load->model('customer/customer');

                $customer_id = '';

                if (!$params['customer_id']) {

                    $customer_data = $params['customer'];

                    $customer_info = $this->model_customer_customer->getCustomerByEmail($customer_data['email']);

                    if ($customer_info) {

                        $customer_id = $customer_info['customer_id'];

                    } else {

                        $customer_id = $this->model_customer_customer->addCustomer($account_info['account_id'], $customer_data);
                    }
                } else {

                    $customer_id = $params['customer_id'];
                }

                // dynamicDecriptor for Semite Payment
                if (isset($params['dynamicDescriptor']) && empty($params['dynamicDescriptor'])) {
                    $authorize->setDynamicDescriptor($params['dynamicDescriptor']);
                }


                $client->call($authorize);

                // do transaction

                // get card information
                $card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);

                if (!$card_status){
                    $this->_api->processApi($this->params, 5007);
                }

                $card_info = $this->_validateCard->GetCardInfo();

                $this->params['transaction'] = array(
                    'account_id'=>$account_info['account_id'],
                    'customer_id'=>$customer_id,
                    'subscription_id'=>0,
                    'fingerprint'=>$this->encryption->encrypt($params['credit_card']['card_num']),
                    'card_number'=>$card_info['substring'],
                    'card_type'=>$card_info['type'],
                    'fee'=>0,
                    'amount'=>$params['amount'],
                    'coupon_id'=>0,
                    'customer_ip_address'=>$params['customer_ip_address'],
                    'status'=>$authorize->getResultState(),
                    'refunded'=>0,
                    'refunded_date'=>0,
                    'captured'=>0,
                    'captured_date'=>0,
                    'voided'=>0,
                    'voided_date'=>0,
                    'authorized'=>1,
                    'authorized_date'=>date('Y-m-d H:s:i'),
                    'sent'=>0,
                    'sent_date'=>0,
                    'received'=>0,
                    'received_date'=>0,
                    'withdrawal'=>0,
                    'withdrawal_date'=>0,
                    'charged'=>0,
                    'charged_date'=>0,
                    'dynamicDescriptor'=>(isset($params['dynamicDescriptor']) ? $params['dynamicDescriptor'] : null),
                    'description'=>(isset($params['customer']) ? $params['description'] : $params['description'])
                );


                // Add transaction
                $this->load->model('transaction/transaction');

                $transaction_id = $this->model_transaction_transaction->addTransaction($account_info['account_id'], $this->params['transaction']);

                $this->params['transactionLog'] = array(
                    'reference'=>$transaction_id,
                    'transaction_state'=>$authorize->getResultState(),
                    'transaction_code'=>$authorize->getResultCode(),
                    'transaction_message'=>$authorize->getResultMessage(),
                    'transaction_id'=>$authorize->getResultTransactionId(),
                    'transaction_guid'=>$authorize->getResultTransactionGuid(),
                    'transaction_date'=>$authorize->getResultTransactionDateTime(),
                    'tracking_code'=>$authorize->getResultTrackingMemberCode(),
                    'enrollment_id'=>0,
                    'issuer_url'=>null,
                    'authentication_request'=>null,
                    'transaction_type'=>TRX_NORMAL,
                    'cdc_data'=>serialize($authorize->getResultCdcData())
                );

                $this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_AUTHORIZE);



                $this->params['activityLog'] = array(
                    'account_id'=>$account_info['account_id'],
                    'key'=>TRX_AUTHORIZE,
                    'data'=>array(
                        'customer_id'=>$customer_id,
                        'amount'=>$params['amount'],
                        'description'=>(isset($params['customer']) ? $params['description'] : $params['description']),
                        'authorized_date'=>date('Y-m-d H:s:i'),
                        'customer_ip_address'=>$params['customer_ip_address']

                    ),
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                );

                // Add to activity log
                $this->load->model('account/activity');

                $this->model_account_activity->addActivity(TRX_AUTHORIZE, $this->params['activityLog']);

                $this->params['transaction_id'] = $transaction_id;
                $this->_api->processApi($this->params, 2000);
            }
            catch (Payvision_Exception $e)
            {

                $this->params['error'] = $e->getMessage();

                $this->_api->processApi($this->params, 5008);
            }

        }

        $this->_api->processApi($this->params, 2000);

    }

    public function Capture(){
        // grab the request
        $request = trim(file_get_contents('php://input'));

        // find out if the request is valid XML
        $xml = @simplexml_load_string($request);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRefund($xml)) {

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

            $this->load->model('report/transaction');

            $transaction = $this->model_report_transaction->getTransaction($account_info['account_id'],$params['transaction_id']);
            $transaction_log = $this->model_report_transaction->getTransactionLog($params['transaction_id'],TRX_AUTHORIZE);


            try {

                $client = new Payvision_Client(Payvision_Client::ENV_TEST);

                $capture = new Payvision_BasicOperations_Capture();
                $capture->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
                $capture->setTransactionIdAndGuid($transaction_log['transaction_id'], $transaction_log['transaction_guid']);

                $capture->setAmountAndCurrencyId((float) $transaction['amount'] , Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

                $capture->setTrackingMemberCode(TRX_CAPTURE.' ' . date('His dmY'));

                $client->call($capture);

                // Update transaction
                $this->load->model('transaction/transaction');

                if ($capture->getResultState()) {

                    $this->model_transaction_transaction->updateTransaction($transaction['transaction_id'],TRX_CAPTURE);
                }

                $this->params['transactionLog'] = array(
                    'reference'=>$params['transaction_id'],
                    'enrollment_id'=>0,
                    'transaction_state'=>$capture->getResultState(),
                    'transaction_code'=>$capture->getResultCode(),
                    'transaction_message'=>$capture->getResultMessage(),
                    'transaction_id'=>$capture->getResultTransactionId(),
                    'transaction_guid'=>$capture->getResultTransactionGuid(),
                    'transaction_date'=>$capture->getResultTransactionDateTime(),
                    'issuer_url'=>null,
                    'tracking_code'=>$capture->getResultTrackingMemberCode(),
                    'authentication_request'=>null,
                    'transaction_type'=>TRX_NORMAL,
                    'cdc_data'=>serialize($capture->getResultCdcData())
                );

                $this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_CHARGE);



                $this->params['activityLog'] = array(
                    'account_id'=>$account_info['account_id'],
                    'key'=>TRX_REFUND,
                    'data'=>array(
                        'reference'=>$params['transaction_id'],
                        'tracking_code'=>$capture->getResultTrackingMemberCode(),
                    ),
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                );

                // Add to activity log
                $this->load->model('account/activity');

                $this->model_account_activity->addActivity(TRX_CAPTURE, $this->params['activityLog']);


                $this->params['transaction_id'] = $params['transaction_id'];


                $this->_api->processApi($this->params, 2000);
            }
            catch (Payvision_Exception $e)
            {

                $this->params['error'] = $e->getMessage();

                $this->_api->processApi($this->params, 5026);
            }
        }

        $this->_api->processApi($this->params, 4006);
    }

    public function Void(){
        // grab the request
        $request = trim(file_get_contents('php://input'));

        // find out if the request is valid XML
        $xml = @simplexml_load_string($request);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRefund($xml)) {

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

            $this->load->model('report/transaction');

            $transaction = $this->model_report_transaction->getTransaction($account_info['account_id'],$params['transaction_id']);
            $transaction_log = $this->model_report_transaction->getTransactionLog($params['transaction_id'],TRX_AUTHORIZE);


            try {

                $client = new Payvision_Client(Payvision_Client::ENV_TEST);

                $void = new Payvision_BasicOperations_Void();
                $void->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
                $void->setTransactionIdAndGuid($transaction_log['transaction_id'], $transaction_log['transaction_guid']);

                $void->setAmountAndCurrencyId((float) $transaction['amount'] , Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

                $void->setTrackingMemberCode(TRX_VOID.' ' . date('His dmY'));

                $client->call($void);

                // Update transaction
                $this->load->model('transaction/transaction');

                if ($void->getResultState()) {

                    $this->model_transaction_transaction->updateTransaction($transaction['transaction_id'],TRX_VOID);
                }

                $this->params['transactionLog'] = array(
                    'reference'=>$params['transaction_id'],
                    'enrollment_id'=>0,
                    'transaction_state'=>$void->getResultState(),
                    'transaction_code'=>$void->getResultCode(),
                    'transaction_message'=>$void->getResultMessage(),
                    'transaction_id'=>$void->getResultTransactionId(),
                    'transaction_guid'=>$void->getResultTransactionGuid(),
                    'transaction_date'=>$void->getResultTransactionDateTime(),
                    'tracking_code'=>$void->getResultTrackingMemberCode(),
                    'issuer_url'=>null,
                    'authentication_request'=>null,
                    'transaction_type'=>TRX_NORMAL,
                    'cdc_data'=>serialize($void->getResultCdcData())
                );

                $this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_VOID);



                $this->params['activityLog'] = array(
                    'account_id'=>$account_info['account_id'],
                    'key'=>TRX_VOID,
                    'data'=>array(
                        'reference'=>$params['transaction_id'],
                        'tracking_code'=>$void->getResultTrackingMemberCode(),
                    ),
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                );

                // Add to activity log
                $this->load->model('account/activity');

                $this->model_account_activity->addActivity(TRX_VOID, $this->params['activityLog']);


                $this->params['transaction_id'] = $params['transaction_id'];


                $this->_api->processApi($this->params, 2000);
            }
            catch (Payvision_Exception $e)
            {

                $this->params['error'] = $e->getMessage();

                $this->_api->processApi($this->params, 5026);
            }
        }

        $this->_api->processApi($this->params, 4006);
    }

	protected function validateCharge($params)
    {

        if (!$params) {

            $params = $this->request->post;
        } else {

            // Make an array out of the XML
            $this->load->library('arraytoxml');
            $params = $this->arraytoxml->toArray($params);
        }

        if (isset($params['customer'])){
            if (!isset($params['customer_id']) || (empty($params['customer_id']))) {

                if ((empty($params['customer']['firstname'])) || (empty($params['customer']['lastname']))) {
                    $this->_api->processApi($this->params, 5003);
                }

                if ((utf8_strlen($params['customer']['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $params['customer']['email'])) {
                    $this->_api->processApi($this->params, 5006);
                }

                if (!$params['customer']['country_id']) {
                    $this->_api->processApi($this->params, 5003);
                }


                if ((empty($params['customer']['address_1'])) || (empty($params['customer']['city'])) || (empty($params['customer']['telephone']))) {
                    $this->_api->processApi($this->params, 5003);
                }
            }

        } else {

            if (!isset($params['dynamicDescriptor']) || empty($params['dynamicDescriptor'])){
                $this->_api->processApi($this->params, 5011);
            }

            if ((!$params['description'])) {
                $this->_api->processApi($this->params, 5003);
            }
        }

		$card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);

		if (!$card_status){
			$this->_api->processApi($this->params, 5007);
		}

		$card_info = $this->_validateCard->GetCardInfo();

		if (($card_info['type'] == 'amex' && (utf8_strlen($params['credit_card']['cvv']) < 4)) || (utf8_strlen($params['credit_card']['cvv']) > 4)){
			$this->_api->processApi($this->params, 5009);
		}

		if (($params['credit_card']['exp_year'] < date('Y')) || ($params['credit_card']['exp_month'] < date('m'))){
			$this->_api->processApi($this->params, 5010);
		}

		return !$this->error;
	}

	protected function validateRefund($params){

		if (!$params){

			$params = $this->request->post;
		} else {

			// Make an array out of the XML
			$this->load->library('arraytoxml');
			$params = $this->arraytoxml->toArray($params);
		}

		return !$this->error;
	}

    protected function validateCapture($params){

        if (!$params){

            $params = $this->request->post;
        } else {

            // Make an array out of the XML
            $this->load->library('arraytoxml');
            $params = $this->arraytoxml->toArray($params);
        }

        return !$this->error;
    }

    protected function validateAuthorize($params){

        if (!$params) {

            $params = $this->request->post;
        } else {

            // Make an array out of the XML
            $this->load->library('arraytoxml');
            $params = $this->arraytoxml->toArray($params);
        }

        if (isset($params['customer'])){
            if (!isset($params['customer_id']) || (empty($params['customer_id']))) {

                if ((empty($params['customer']['firstname'])) || (empty($params['customer']['lastname']))) {
                    $this->_api->processApi($this->params, 5003);
                }

                if ((utf8_strlen($params['customer']['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $params['customer']['email'])) {
                    $this->_api->processApi($this->params, 5006);
                }

                if (!$params['customer']['country_id']) {
                    $this->_api->processApi($this->params, 5003);
                }


                if ((empty($params['customer']['address_1'])) || (empty($params['customer']['city'])) || (empty($params['customer']['telephone']))) {
                    $this->_api->processApi($this->params, 5003);
                }
            }

        } else {

            if (!isset($params['dynamicDescriptor']) || empty($params['dynamicDescriptor'])){
                $this->_api->processApi($this->params, 5011);
            }

            if ((!$params['description'])) {
                $this->_api->processApi($this->params, 5003);
            }
        }

        $card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);

        if (!$card_status){
            $this->_api->processApi($this->params, 5007);
        }

        $card_info = $this->_validateCard->GetCardInfo();

        if (($card_info['type'] == 'amex' && (utf8_strlen($params['credit_card']['cvv']) < 4)) || (utf8_strlen($params['credit_card']['cvv']) > 4)){
            $this->_api->processApi($this->params, 5009);
        }

        if (($params['credit_card']['exp_year'] < date('Y')) || ($params['credit_card']['exp_month'] < date('m'))){
            $this->_api->processApi($this->params, 5010);
        }

        return !$this->error;
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
