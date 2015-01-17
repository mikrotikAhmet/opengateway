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
 * Description of gateway.php Class
**/


class ControllerV3Gateway extends Controller {

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
                $count = 0;

                $client = new Payvision_Client(Payvision_Client::ENV_TEST);

                $charge = new Payvision_ThreeDSecureOperations_CheckEnrollment();
                $charge->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
                $charge->setCountryId(Payvision_Translator::getCountryIdFromIso($country_info['iso_code_3']));

                $charge->setCardNumberAndHolder($params['credit_card']['card_num'],(isset($params['credit_card']['card_holder']) ? $params['credit_card']['card_holder'] : null));
                $charge->setCardExpiry($params['credit_card']['exp_month'], $params['credit_card']['exp_year']);

                $charge->setAmountAndCurrencyId((float) $params['amount'], Payvision_Translator::getCurrencyIdFromIsoCode($account_info['currency_code']));

                $charge->setTrackingMemberCode('CheckEnrollment ' . date('His dmY'));

                if ($client->call($charge))
                {
                    // Add transaction
                    $this->load->model('transaction/transaction');

                    $this->params['transactionLog'] = array(
                        'reference'=>0,
                        'transaction_state'=>$charge->getResultState(),
                        'transaction_code'=>$charge->getResultCode(),
                        'transaction_message'=>$charge->getResultMessage(),
                        'enrollment_id'=>$charge->getResultEnrollmentId(),
                        'issuer_url'=>$charge->getResultIssuerUrl(),
                        'transaction_id'=>0,
                        'transaction_guid'=>0,
                        'transaction_date'=>date('Y-m-d H:s:i'),
                        'authentication_request'=>($charge->getResultPaymentAuthenticationRequest() ? $charge->getResultPaymentAuthenticationRequest() : 'X'),
                        'tracking_code'=>$charge->getResultTrackingMemberCode(),
                        'transaction_type'=>TRX_3DSECURE,
                        'cdc_data'=>serialize($charge->getResultCdcData())
                    );


                    $this->model_transaction_transaction->addTransactionLog($this->params['transactionLog'],TRX_CHARGE);

//                    Whether transaction goes well or not check with error 3000. if it is then use MPI method or let 3dsecure page appear.


                    if ($charge->getResultCode()){
                        $this->response->redirect('http://dashboard.semite.com/index.php?route=common/MPISuccess&securityCode='.$params['credit_card']['cvv'].'&enrollmentId='.$charge->getResultEnrollmentId());
                        exit();
                    }

                    echo $charge->getRedirectHtmlForm('http://dashboard.semite.com/index.php?route=common/MPISuccess&securityCode='.$params['credit_card']['cvv'].'&enrollmentId='.$charge->getResultEnrollmentId());


                }

            }
            catch (Payvision_Exception $e)
            {

                $this->params['error'] = $e->getMessage();

                $this->_api->processApi($this->params, 5008);
            }

        }

        $this->_api->processApi($this->params, 2000);
    }

    public function doPayment(){

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


        try
        {

            $client = new Payvision_Client(Payvision_Client::ENV_TEST);

            $payment = new Payvision_ThreeDSecureOperations_PaymentUsingIntegratedMPI();
            $payment->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
            $payment->setCountryId(Payvision_Translator::getCountryIdFromIso($country_info['iso_code_3']));

            $payment->setTrackingMemberCode('PaymentAuthorizeUsingIntegratedMPI ' . date('His dmY'));

            $payment->setCardValidationCode($params['securityCode']);

            // ID returned in the Enrollment check: $operation->getResultEnrollmentId()
            $payment->setEnrollmentId($params['enrollmentId']);

            // Tracking Member Code used in the Enrollment check
            $payment->setEnrollmentTrackingMemberCode($params['memberTrackingCode']);

            // Provided in redirection after 3D secure check: $_POST['PaRes']
            $payment->setPayerAuthenticationResponse($params['paResult']);

            $client->call($payment);

            echo '<pre>';
            print_r($payment);

        }
        catch (Payvision_Exception $e)
        {
            $this->params['error'] = $e->getMessage();

            $this->_api->processApi($this->params, 5008);
        }

        }

        $this->_api->processApi($this->params, 2000);

    }


    protected function validateCharge($params)
    {

//        if (!$params) {
//
//            $params = $this->request->post;
//        } else {
//
//            // Make an array out of the XML
//            $this->load->library('arraytoxml');
//            $params = $this->arraytoxml->toArray($params);
//        }
//
//        if (isset($params['customer'])){
//            if (!isset($params['customer_id']) || (empty($params['customer_id']))) {
//
//                if ((empty($params['customer']['firstname'])) || (empty($params['customer']['lastname']))) {
//                    $this->_api->processApi($this->params, 5003);
//                }
//
//                if ((utf8_strlen($params['customer']['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $params['customer']['email'])) {
//                    $this->_api->processApi($this->params, 5006);
//                }
//
//                if (!$params['customer']['country_id']) {
//                    $this->_api->processApi($this->params, 5003);
//                }
//
//
//                if ((empty($params['customer']['address_1'])) || (empty($params['customer']['city'])) || (empty($params['customer']['telephone']))) {
//                    $this->_api->processApi($this->params, 5003);
//                }
//            }
//
//        } else {
//
//            if (!isset($params['dynamicDescriptor']) || empty($params['dynamicDescriptor'])){
//                $this->_api->processApi($this->params, 5011);
//            }
//
//            if ((!$params['description'])) {
//                $this->_api->processApi($this->params, 5003);
//            }
//        }
//
//        $card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);
//
//        if (!$card_status){
//            $this->_api->processApi($this->params, 5007);
//        }
//
//        $card_info = $this->_validateCard->GetCardInfo();
//
//        if (($card_info['type'] == 'amex' && (utf8_strlen($params['credit_card']['cvv']) < 4)) || (utf8_strlen($params['credit_card']['cvv']) > 4)){
//            $this->_api->processApi($this->params, 5009);
//        }
//
//        if (($params['credit_card']['exp_year'] < date('Y')) || ($params['credit_card']['exp_month'] < date('m'))){
//            $this->_api->processApi($this->params, 5010);
//        }

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