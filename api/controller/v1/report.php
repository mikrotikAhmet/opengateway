<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 7:49 PM
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

class ControllerV1Report extends Controller {

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

	public function getTransaction(){

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

				$account_info = $this->model_system_auth->getAccount($params['authentication']['api_id'],$params['authentication']['secret_key']);
			}


			$this->load->model('report/transaction');
			$this->load->model('customer/customer');

			$transaction = $this->model_report_transaction->getTransaction($account_info['account_id'],$params['transaction_id']);
			$transaction_log = $this->model_report_transaction->getTransactionLog($params['transaction_id']);
			$customer = $this->model_customer_customer->getCustomer($transaction['customer_id']);

			$this->params['transaction'] = array(
				'transaction'=>$transaction,
				'customer'=>($customer ? $customer : array()),
				'transaction_log'=>$transaction_log
			);

			$this->_api->processApi($this->params, 2000);

		}

		$this->_api->processApi($this->params, 4006);

	}

    public function getTransactions(){

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

			if (isset($params['filter']['filter_date_start'])) {
				$filter_date_start = $params['filter']['filter_date_start'];
			} else {
				$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
			}

			if (isset($params['filter']['filter_date_end'])) {
				$filter_date_end = $params['filter']['filter_date_end'];
			} else {
				$filter_date_end = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
			}

			if (isset($params['filter']['date_interval'])) {
				$date_interval = $params['filter']['date_interval'];
			} else {
				$date_interval = 30;
			}

			if (isset($params['filter']['page'])) {
				$page = $params['filter']['page'];
			} else {
				$page = 1;
			}

			$this->load->model('report/transaction');

			$filter_data = array(
				'filter_date_start' => $filter_date_start,
				'filter_date_end' =>  $filter_date_end,
				'sort'  => 'date_added',
				'order' => 'DESC',
				'start' => ($page - 1) * (isset($params['filter']['limit']) ? $params['filter']['limit'] : $this->config->get('config_item_limit')),
				'limit' => (isset($params['filter']['limit']) ? $params['filter']['limit'] : $this->config->get('config_item_limit'))
			);

			$this->params['transactions'] = array();

			$transaction_total = $this->model_report_transaction->getTotalTransactions($params['account_id'],$filter_data);

			$transactions = $this->model_report_transaction->getTransactions($params['account_id'],$filter_data);

			$transaction_type = "";
            $this->params['total_transactions'] = 0;

			if ($transaction_total) {
				foreach ($transactions as $transaction) {

					// Check Transaction type
					if ($transaction['charged']){
						$transaction_type = TRX_CHARGE;
					}
					if ($transaction['refunded']){
						$transaction_type = TRX_REFUND;
					}
					if ($transaction['captured']){
						$transaction_type = TRX_CAPTURE;
					}
					if ($transaction['voided']){
						$transaction_type = TRX_VOID;
					}
					if ($transaction['authorized']){
						$transaction_type = TRX_AUTHORIZE;
					}
					if ($transaction['sent']){
						$transaction_type = TRX_SENT;
					}
					if ($transaction['received']){
						$transaction_type = TRX_RECEIVE;
					}
					if ($transaction['withdrawal']){
						$transaction_type = TRX_WITHDRAW;
					}
					if ($transaction['verified']){
						$transaction_type = TRX_VERIFY;
					}

					$this->params['transactions'][] = array(
						'transaction_id' => $transaction['transaction_id'],
						'amount' => $this->currency->format($transaction['amount'], $this->account->getCurrencyCode(), 1),
						'fee'=>$this->currency->format($transaction['fee'], $this->account->getCurrencyCode(), 1),
						'type'=>$transaction_type,
						'status'=>(!$transaction['status'] ? TRX_ST_FAILED : TRX_ST_PROCESSED),
						'date_added' => $transaction['date_added'],
					);
				}

				$this->params['total_transactions'] = $transaction_total;

			} else {
				$this->_api->processApi($this->params, 5002);
			}


			$this->_api->processApi($this->params, 2000);

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