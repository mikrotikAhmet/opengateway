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

class ControllerAccountTransaction extends Controller{
    
    private $error = array();
    
    public function index(){

        $this->language->load('account/transaction');
        
        $this->getList();
    }
    
    protected function getList(){

        $this->load->model('opengateway/setting');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_search'] = $this->language->get('text_search');

        $params = array();

        // Get Customer Transactions
        $api_response = $this->_api->apiPost('v1/customer/getAllTransactions',$params);

        $data = json_decode($api_response);

        $this->data['transactions'] = array();

        if ($data->status == "OK") {

            foreach ($data->data as $transactions) {

                $status = $this->model_opengateway_setting->getStatus($transactions->status);


                $this->data['transactions'][] = array(
                    'transaction_id' => $transactions->transaction_id,
                    'action'=>$transactions->action_type,
                    'description'=>$transactions->description,
                    'invoice_no'=>$this->config->get('config_invoice_prefix').$transactions->invoice_no,
                    'total'=>$this->currency->format_settlement($transactions->amount,$this->config->get('config_currency')),
                    'converted'=>$this->currency->format($transactions->amount, $this->customer->getCustomerCurrencyCode(),$transactions->conversion_value),
                    'convertion_rate'=>  sprintf($this->language->get('text_convertion_rate'),$this->config->get('config_currency'),$transactions->conversion_value,$this->customer->getCustomerCurrencyCode()),
                    'date'=>date($this->language->get('date_format_short'), strtotime($transactions->date_added)),
                    'status'=>$status['name']
                );
            }
        }
        
        $this->template = 'account/transaction_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

