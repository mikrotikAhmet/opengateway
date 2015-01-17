<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 7:41 PM
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

class ControllerReportTransaction extends Controller {

    public function allTransactions()
    {

            $this->language->load('report/transaction');

            $data['text_last_transaction'] = $this->language->get('text_last_transaction');
            $data['text_no_transaction'] = $this->language->get('text_no_transaction');

            $data['column_date_added'] = $this->language->get('column_date_added');
            $data['column_description'] = $this->language->get('column_description');
            $data['column_fee'] = $this->language->get('column_fee');
            $data['column_amount'] = sprintf($this->language->get('column_amount'), $this->currency->getCode());
            $data['column_status'] = $this->language->get('column_status');

            $data['button_all_transaction'] = $this->language->get('button_all_transaction');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['filter_date_start'])) {
            $data['filter_date_start'] = $this->request->get['filter_date_start'];
        } else {
            $data['filter_date_start'] = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $data['filter_date_end']= $this->request->get['filter_date_end'];
        } else {
            $data['filter_date_end'] = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
        }

        if (isset($this->request->get['date_interval'])) {
            $data['date_interval']  = $this->request->get['date_interval'];
        } else {
            $data['date_interval']  = 30;
        }


            $url = "http://".API_BASE."/v1/report/getTransactions";

            // XML Request

            $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>' . $this->account->getApiId() . '</api_id>
		<secret_key>' . $this->account->getApiSecret() . '</secret_key>
	</authentication>
	<request>getTransactions</request>
	<account_id>' . $this->account->getId() . '</account_id>
	<filter>
		<page>'.$page.'</page>
	    <filter_date_start>'.$data['filter_date_start'].'</filter_date_start>
	    <filter_date_end>'.$data['filter_date_end'].'</filter_date_end>
	</filter>
</request>';

            $postfields = $post_string;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                print curl_error($ch);
            } else {
                curl_close($ch);
                $transactions = json_decode($response);
            }

            $data['showpagination'] = true;
            $data['transactions'] = array();

        $this->document->addScript('view/javascript/jquery/datetimepicker/moment.min.js');
        $this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $data['text_filter_transaction'] = $this->language->get('text_filter_transaction');
        $data['text_date_range'] = $this->language->get('text_date_range');

        $data['interval_m_30'] = $this->language->get('interval_m_30');
        $data['interval_m_60'] = $this->language->get('interval_m_60');
        $data['interval_m_90'] = $this->language->get('interval_m_90');
        $data['interval_m_180'] = $this->language->get('interval_m_180');


        $data['export'] = $this->url->link('account/transaction/export','token='.$this->session->data['token'],'SSL');

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . urlencode(html_entity_decode($this->request->get['filter_date_start'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . urlencode(html_entity_decode($this->request->get['filter_date_end'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (count($transactions)) {
            foreach ($transactions->transactions as $transaction) {

                $data['transactions'][] = array(
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => $this->currency->format($transaction->amount, $this->account->getCurrencyCode(), 1),
                    'fee' => $this->currency->format($transaction->fee, $this->account->getCurrencyCode(), 1),
                    'type' => $transaction->type,
                    'status' => $transaction->status,
                    'date_added' => date($this->language->get('date_format_short'), strtotime($transaction->date_added)),
                );

            }
        }

        $pagination = new Pagination();
        $pagination->total = $transactions->total_transactions;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_item_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/transaction/allTransactions', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($transactions->total_transactions) ? (($page - 1) * $this->config->get('config_item_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_item_limit')) > ($transactions->total_transactions - $this->config->get('config_item_limit'))) ? $transactions->total_transactions : ((($page - 1) * $this->config->get('config_item_limit')) + $this->config->get('config_item_limit')), $transactions->total_transactions, ceil($transactions->total_transactions / $this->config->get('config_item_limit')));

        $data['token'] = $this->session->data['token'];

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('report/transaction.tpl', $data));
    }

	public function lastTransactions(){

		$this->language->load('report/transaction');

		$data['text_last_transaction'] = $this->language->get('text_last_transaction');
		$data['text_no_transaction'] = $this->language->get('text_no_transaction');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_fee'] = $this->language->get('column_fee');
		$data['column_amount'] = sprintf($this->language->get('column_amount'),$this->currency->getCode());
		$data['column_status'] = $this->language->get('column_status');

		$data['button_all_transaction'] = $this->language->get('button_all_transaction');

        $data['transaction_all'] = $this->url->link('report/transaction/allTransactions','token='.$this->session->data['token'], 'SSL');


		$url = "http://".API_BASE."/v1/report/getTransactions";

		// XML Request

		$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>getTransactions</request>
	<account_id>'.$this->account->getId().'</account_id>
    <filter>
        <limit>10</limit>
	    <page>1</page>
	</filter>
</request>';

		$postfields = $post_string;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


		$response = curl_exec($ch);

		if(curl_errno($ch))
		{
			print curl_error($ch);
		}
		else
		{
			curl_close($ch);
			$transactions = json_decode($response);
		}

        $data['showpagination'] = false;
		$data['transactions'] = array();

		$page = 1;

		if (count($transactions)) {
			foreach ($transactions->transactions as $transaction) {

				$data['transactions'][] = array(
					'transaction_id' => $transaction->transaction_id,
					'amount' => $this->currency->format($transaction->amount, $this->account->getCurrencyCode(), 1),
					'fee' => $this->currency->format($transaction->fee, $this->account->getCurrencyCode(), 1),
					'type' => $transaction->type,
					'status' => $transaction->status,
					'date_added' => date($this->language->get('date_format_short'), strtotime($transaction->date_added)),
				);

			}

			$data['results'] = sprintf($this->language->get('text_pagination'), ($transactions->total_transactions) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transactions->total_transactions - 10)) ? $transactions->total_transactions : ((($page - 1) * 10) + 10), $transactions->total_transactions, ceil($transactions->total_transactions / 10));

		} else {

			$data['results'] = sprintf($this->language->get('text_pagination'), (0) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > (0 - 10)) ? 0 : ((($page - 1) * 10) + 10), 0, ceil(0 / 10));
		}

		$data['token'] = $this->session->data['token'];

		$this->response->setOutput($this->load->view('report/json/transaction.tpl', $data));

	}

	public function detail(){

		sleep(1);

        $data['back'] = $this->url->link('common/dashboard','token='.$this->session->data['token'], 'SSL');

		$transaction_id = $this->request->get['transaction_id'];
		if (isset($this->request->get['json'])) {
			$json = true;
		} else {
			$json = false;
		}

		$url = "http://".API_BASE."/v1/report/getTransaction";

		// XML Request

		$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>getTransaction</request>
	<transaction_id>'.$transaction_id.'</transaction_id>
</request>';

		$postfields = $post_string;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


		$response = curl_exec($ch);

		if(curl_errno($ch))
		{
			print curl_error($ch);
		}
		else
		{
			curl_close($ch);
			$transaction = json_decode($response);
		}

        $data['transaction'] = array();


        if (count($transaction)) {

            $transaction_info = current($transaction);

            if (count($transaction_info->customer)) {

                $this->load->model('localisation/zone');
                $this->load->model('localisation/country');

                $zone_info = $this->model_localisation_zone->getZone($transaction_info->customer->zone_id);
                $country_info = $this->model_localisation_country->getCountry($transaction_info->customer->country_id);
            }

            $data['transaction'] = array(
                'general' => array(
                    'transaction_id' => $transaction_info->transaction->transaction_id,
                    'amount' => $this->currency->format($transaction_info->transaction->amount, $this->account->getCurrencyCode(), 1),
                    'transaction_date' => date($this->language->get('date_format_long'), strtotime($transaction_info->transaction->date_added)),
                    'status' => ($transaction_info->transaction->status ? '<i class="fa fa-check-square-o"></i> ' . TRX_ST_PROCESSED : '<i class="fa fa-warning"></i> ' . TRX_ST_FAILED),
                    'card_number' => $transaction_info->transaction->card_number,
                    'card_type' => $transaction_info->transaction->card_type,
                    'gateway' => $this->config->get('config_name'),
                    'charged' => $transaction_info->transaction->charged,
                    'refunded' => $transaction_info->transaction->refunded,
                    'authorized' => $transaction_info->transaction->authorized,
                    'captured' => $transaction_info->transaction->captured,
                    'voided' => $transaction_info->transaction->voided,
                    'additionalInfo' => unserialize($transaction_info->transaction->additionalInfo),
                ),
                'authorization' => array(
                    'transaction_id' => $transaction_info->transaction->transaction_id,
                    'transaction_state' => $transaction_info->transaction_log->transaction_state,
                    'external_transaction_id' => (isset($transaction_info->transaction_log->transaction_id) ? $transaction_info->transaction_log->transaction_id : 0),
                    'original_amount' => $transaction_info->transaction->amount,
                    'tracking_code' => (isset($transaction_info->transaction_log->tracking_code) ? $transaction_info->transaction_log->tracking_code : 0),
                    'transaction_guid' => (isset($transaction_info->transaction_log->transaction_guid) ? $transaction_info->transaction_log->transaction_guid : 0),
                    'reference' => (isset($transaction_info->transaction_log->reference) ? $transaction_info->transaction_log->reference : 0),
                )
            );

            if (count($transaction_info->customer)){

                $data['transaction']['customer'] = array(
                    'name' => $transaction_info->customer->firstname . ' ' . strtoupper($transaction_info->customer->lastname),
                    'email' => $transaction_info->customer->email,
                    'company' => (!empty($transaction_info->customer->company) ? $transaction_info->customer->company : 'Not specified'),
                    'address' => $transaction_info->customer->address_1 . '<br/>' . $transaction_info->customer->address_2 . '<br/>' . $transaction_info->customer->city . ',' . ($zone_info ? $zone_info['name'] : null) . '<br/>' . $country_info['iso_code_3'] . '<br/>' . $transaction_info->customer->postcode,
                    'phone' => $transaction_info->customer->telephone,
	                'href' => $this->url->link('account/customer/edit','token='.$this->session->data['token'].'&customer_id='.$transaction_info->customer->customer_id,'SSL'),
                    'additionalInfo' => unserialize(unserialize($transaction_info->transaction->additionalInfo)),
                );
            }
        }

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		if ($json) {
			$this->response->setOutput($this->load->view('report/json/transaction_detail.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('report/transaction_detail.tpl', $data));
		}
	}

    public function export(){

        $this->load->model('gateway/transaction');

        $transactions = $this->model_gateway_transaction->getTransactions();

        $export = new Csv();

        $balance = 0;

        foreach ($transactions as $key=>$transaction){

            if (!$transaction['external_transaction_code'] && $transaction['transaction_type'] != TRX_VERIFY){
                $balance = $balance + $transaction['amount'];
            }

            $export_data[] = array(
                'ID'=>$transaction['transaction_id'],
                'Date Created'=>date($this->language->get('date_format_short'), strtotime($transaction['date_added'])),
                'Type'=>$transaction['transaction_type'],
                '[-]'.$this->account->getCurrencyCode() => (($transaction['amount'] < 0) ? $transaction['amount'] : 0),
                '[+]'.$this->account->getCurrencyCode() => (($transaction['amount'] > 0) ? $transaction['amount'] : 0),
                'status'=>$transaction['external_transaction_code'] ? 'Fail' : 'Completed',
                'Balance'=> $balance
            );
        }

        $export->toCSV($export_data);
    }
}