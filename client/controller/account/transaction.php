<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 * OGCA
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC..
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * @package     Semite LLC
 * @version     $Id: transaction.php Oct 6, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of transaction  Class
 *
 * @author ahmet
 */
/*
 * Copyright (C) 2014 ahmet
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ControllerAccountTransaction extends Controller {

    private $error = array();

    public function index() {

        $this->language->load('account/transaction');

        $this->getList();
    }

    protected function getList() {

        $this->load->model('opengateway/setting');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_no_result'] = $this->language->get('text_no_result');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_date_range'] = $this->language->get('text_date_range');
        $this->data['text_export_csv'] = $this->language->get('text_export_csv');
        

        $this->data['column_transaction'] = $this->language->get('column_transaction');
        $this->data['column_type'] = $this->language->get('column_type');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_date'] = $this->language->get('column_date');
        $this->data['column_status'] = $this->language->get('column_status');

        $this->data['details_invoice_no'] = $this->language->get('details_invoice_no');
        $this->data['details_amount'] = $this->language->get('details_amount');
        $this->data['details_conversation'] = $this->language->get('details_conversation');
        $this->data['details_rate'] = $this->language->get('details_rate');
        $this->data['details_description'] = $this->language->get('details_description');
        $this->data['details_status'] = $this->language->get('details_status');
        $this->data['details_action'] = $this->language->get('details_action');
        
        $this->data['interval_m_30'] = $this->language->get('interval_m_30');
        $this->data['interval_m_60'] = $this->language->get('interval_m_60');
        $this->data['interval_m_90'] = $this->language->get('interval_m_90');
        $this->data['interval_m_180'] = $this->language->get('interval_m_180');

        $this->data['button_capture'] = $this->language->get('button_capture');
        $this->data['button_refund'] = $this->language->get('button_refund');
        $this->data['button_search'] = $this->language->get('button_search');

        $this->data['token'] = $this->session->data['token'];
        
        $this->data['export'] = $this->url->link('account/transaction/export', 'token='.$this->session->data['token'], 'SSL');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = date('Y-m-d');
        }
        
        if (isset($this->request->get['date_interval'])) {
            $date_interval = $this->request->get['date_interval'];
        } else {
            $date_interval = 30;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        if (isset($this->request->get['date_interval'])) {
            $url .= '&date_interval=' . $this->request->get['date_interval'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $params = array(
            'filter_date_start' => $filter_date_start,
            'filter_date_end' => $filter_date_end,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        // Get Customer Transactions
        $api_response = $this->_api->apiGet('v1/customer/getAllTransactions', $params);

        $data = json_decode($api_response);

        $this->data['transactions'] = array();

        if ($data->status == "OK") {

            foreach ($data->data as $transactions) {

                $status = $this->model_opengateway_setting->getStatus($transactions->status);


                $this->data['transactions'][] = array(
                    'transaction_id' => $transactions->transaction_id,
                    'action' => $transactions->action_type,
                    'description' => $transactions->description,
                    'invoice_no' => $this->config->get('config_invoice_prefix') . $transactions->invoice_no,
                    'total' => $this->currency->format_settlement($transactions->amount, $this->config->get('config_currency')),
                    'converted' => $this->currency->format($transactions->amount, $this->customer->getCustomerCurrencyCode(), $transactions->conversion_value),
                    'convertion_rate' => sprintf($this->language->get('text_convertion_rate'), $this->config->get('config_currency'), $transactions->conversion_value, $this->customer->getCustomerCurrencyCode()),
                    'date' => date($this->language->get('date_format_short'), strtotime($transactions->date_added)),
                    'status' => $status['name']
                );
            }
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        if (isset($this->request->get['date_interval'])) {
            $url .= '&date_interval=' . $this->request->get['date_interval'];
        }


        $pagination = new Pagination();
        $pagination->total = (count($data->data) ? count($data->data) + 1 : 0);
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('account/transaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_date_start'] = $filter_date_start;
        $this->data['filter_date_end'] = $filter_date_end;
        $this->data['date_interval'] = $date_interval;
        
        

        $this->template = 'account/transaction_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    
    public function export(){
        $export = new Csv();
        
        
        $data = array(
            array("firstname" => "Mary", "lastname" => "Johnson", "age" => 25),
            array("firstname" => "Amanda", "lastname" => "Miller", "age" => 18),
            array("firstname" => "James", "lastname" => "Brown", "age" => 31),
            array("firstname" => "Patricia", "lastname" => "Williams", "age" => 7),
            array("firstname" => "Michael", "lastname" => "Davis", "age" => 43),
            array("firstname" => "Sarah", "lastname" => "Miller", "age" => 24),
            array("firstname" => "Patrick", "lastname" => "Miller", "age" => 27)
          );
        
        $export->toCSV($data);
    }

}


