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
 * Description of account.php Class
**/


class ControllerV1Account extends Controller {

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

	public function addCard(){

		// grab the request
		$request = trim(file_get_contents('php://input'));

		// find out if the request is valid XML
		$xml = @simplexml_load_string($request);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCard($xml)) {

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
			$card_info = $this->_validateCard->GetCardInfo();

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'account_id' => $account_info['account_id'],
				'ip'        => $params['customer_ip_address'],
				'card_num'=>$card_info['substring']
			);

			$this->model_account_activity->addActivity('addCard', $activity_data);

			$this->load->model('account/card');

			$data = array(
				'card_num'=>$card_info['substring'],
				'expire_date'=>$params['credit_card']['exp_month'].'-'.$params['credit_card']['exp_year'],
				'cvv'=>$params['credit_card']['cvv'],
				'fingerprint'=>$this->encryption->encrypt($params['credit_card']['card_num']),
				'type'=>$card_info['type'],
			);

			$this->model_account_card->addCard($account_info['account_id'],$data);


			$this->_api->processApi($this->params, 2000);
		}

		$this->_api->processApi($this->params, 5006);

	}

    public function getCustomers(){
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

            if (isset($params['filter']['filter_name'])) {
                $filter_name = $params['filter']['filter_name'];
            } else {
                $filter_name = null;
            }

            if (isset($params['filter']['filter_email'])) {
                $filter_email = $params['filter']['filter_email'];
            } else {
                $filter_email = null;
            }

            if (isset($params['filter']['filter_date_added'])) {
                $filter_date_added = $params['filter']['filter_date_added'];
            } else {
                $filter_date_added = null;
            }

            if (isset($params['filter']['sort'])) {
                $sort = $params['filter']['sort'];
            } else {
                $sort = 'name';
            }

            if (isset($params['filter']['order'])) {
                $order = $params['filter']['order'];
            } else {
                $order = 'ASC';
            }

            if (isset($params['filter']['page'])) {
                $page = $params['filter']['page'];
            } else {
                $page = 1;
            }

            $this->load->model('customer/customer');

            $data['customers'] = array();

            $filter_data = array(
                'filter_name'              => $filter_name,
                'filter_email'             => $filter_email,
                'filter_date_added'        => $filter_date_added,
                'sort'                     => $sort,
                'order'                    => $order,
                'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
                'limit'                    => $this->config->get('config_limit_admin')
            );

            $customer_total = $this->model_customer_customer->getTotalCustomers($filter_data);

            $results = $this->model_customer_customer->getCustomers($filter_data);

            $this->params['total_customers'] = 0;

            if ($customer_total) {

                foreach ($results as $result) {

                    $this->params['customers'][] = array(
                        'customer_id' => $result['customer_id'],
                        'name' => $result['name'],
                        'email' => $result['email'],
                        'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                    );
                }

                $this->params['total_customers'] = $customer_total;
            } else {
                $this->_api->processApi($this->params, 5002);
            }

            $this->_api->processApi($this->params, 2000);
        }

        $this->_api->processApi($this->params, 4006);
    }

    public function getCustomer(){
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

            $this->load->model('customer/customer');

            $customer_data = $this->model_customer_customer->getCustomer($params['customer_id']);

            $this->params['Customer_Object'] = $customer_data;

            $this->_api->processApi($this->params, 2000);
        }

        $this->_api->processApi($this->params, 4006);
    }

    public function updateCustomer(){

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

            $this->load->model('customer/customer');

            $this->model_customer_customer->editCustomer($params['customer_id'],current(json_decode($params['customer'])));

            $this->_api->processApi($this->params, 2000);
        }

        $this->_api->processApi($this->params, 4006);
    }

	public function addCustomer(){

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

			$this->load->model('customer/customer');

			$this->model_customer_customer->newCustomer($this->account->getId(),current(json_decode($params['customer'])));

			$this->_api->processApi($this->params, 2000);
		}

		$this->_api->processApi($this->params, 4006);
	}

	protected function validateCard($params){

		if (!$params){

			$params = $this->request->post;
		} else {

			// Make an array out of the XML
			$this->load->library('arraytoxml');
			$params = $this->arraytoxml->toArray($params);
		}


		$card_status = $this->_validateCard->Validate($params['credit_card']['card_num']);

		if (!$card_status){
			$this->error['warning'] = $this->_api->processApi($this->params, 5007);
		}

		$card_info = $this->_validateCard->GetCardInfo();

		if (($card_info['type'] == 'amex' && (utf8_strlen($params['credit_card']['cvv']) < 4)) || (utf8_strlen($params['credit_card']['cvv']) > 4)){
			$this->error['warning'] = $this->_api->processApi($this->params, 5009);
		}

		if (($params['credit_card']['exp_year'] < date('Y')) || ($params['credit_card']['exp_month'] < date('m'))){
			$this->error['warning'] = $this->_api->processApi($this->params, 5010);
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