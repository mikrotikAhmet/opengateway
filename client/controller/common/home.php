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
 * @version     $Id: home.php Oct 4, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of home  Class
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

class ControllerCommonHome extends Controller {

    public function index() {

        $this->language->load('common/home');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_result'] = $this->language->get('text_no_result');

        $this->data['text_last_transaction'] = $this->language->get('text_last_transaction');
        $this->data['text_general_balance'] = $this->language->get('text_general_balance');
        $this->data['text_balance'] = $this->language->get('text_balance');

        $this->data['column_transaction'] = $this->language->get('column_transaction');
        $this->data['column_type'] = $this->language->get('column_type');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_date'] = $this->language->get('column_date');
        $this->data['column_status'] = $this->language->get('column_status');

        $this->data['button_deposit'] = $this->language->get('button_deposit');
        $this->data['button_withdraw'] = $this->language->get('button_withdraw');
        $this->data['button_send'] = $this->language->get('button_send');
        $this->data['button_capture'] = $this->language->get('button_capture');
        $this->data['button_refund'] = $this->language->get('button_refund');

        // Check install directory exists
        if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
            $this->data['error_install'] = $this->language->get('error_install');
        } else {
            $this->data['error_install'] = '';
        }

        // Check image directory is writable
        $file = DIR_IMAGE . 'test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_image'] = sprintf($this->language->get('error_image'), DIR_IMAGE);
        } else {
            $this->data['error_image'] = '';

            unlink($file);
        }

        // Check image cache directory is writable
        $file = DIR_IMAGE . 'cache/test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_image_cache'] = sprintf($this->language->get('error_image_cache'), DIR_IMAGE . 'cache/');
        } else {
            $this->data['error_image_cache'] = '';

            unlink($file);
        }

        // Check cache directory is writable
        $file = DIR_CACHE . 'test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_cache'] = sprintf($this->language->get('error_image_cache'), DIR_CACHE);
        } else {
            $this->data['error_cache'] = '';

            unlink($file);
        }

        // Check download directory is writable
        $file = DIR_DOWNLOAD . 'test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_download'] = sprintf($this->language->get('error_download'), DIR_DOWNLOAD);
        } else {
            $this->data['error_download'] = '';

            unlink($file);
        }

        // Check document directory is writable
        $file = DIR_DOCUMENT . 'test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_document'] = sprintf($this->language->get('error_document'), DIR_DOCUMENT);
        } else {
            $this->data['error_document'] = '';

            unlink($file);
        }

        // Check logs directory is writable
        $file = DIR_LOGS . 'test';

        $handle = fopen($file, 'a+');

        fwrite($handle, '');

        fclose($handle);

        if (!file_exists($file)) {
            $this->data['error_logs'] = sprintf($this->language->get('error_logs'), DIR_LOGS);
        } else {
            $this->data['error_logs'] = '';

            unlink($file);
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['token'] = $this->session->data['token'];

        $this->load->model('opengateway/setting');
        
        if ($this->config->get('config_currency_auto')) {
            $this->load->model('localisation/currency');

            $this->model_localisation_currency->updateCurrencies();
        }

        $this->data['deposit'] = $this->url->link('account/deposit', 'token=' . $this->session->data['token'], 'SSL');

        // Get Customer Balance
        $api_response = $this->_api->apiGet('v1/customer/getBalance');

        $data = json_decode($api_response);

        if ($data->status == "OK") {
            $this->data['balance'] = $this->currency->format($data->data->balance, $this->customer->getCustomerCurrencyCode());
        }

        // Get Customer Transactions
        $api_response = $this->_api->apiGet('v1/customer/getLastTransactions');

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
                    'total'=>$this->currency->format($transactions->amount,$this->config->get('config_currency')),
                    'date'=>date($this->language->get('date_format_short'), strtotime($transactions->date_added)),
                    'status'=>$status['name']
                );
            }
        }
        
        $this->template = 'common/home.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function login() {
        $route = '';

        if (isset($this->request->get['route'])) {
            $part = explode('/', $this->request->get['route']);

            if (isset($part[0])) {
                $route .= $part[0];
            }

            if (isset($part[1])) {
                $route .= '/' . $part[1];
            }
        }

        $ignore = array(
            'common/login',
            'common/forgotten',
            'common/reset'
        );

        if (!$this->customer->isLogged() && !in_array($route, $ignore)) {
            return $this->forward('common/login');
        }

        if (isset($this->request->get['route'])) {
            $ignore = array(
                'common/login',
                'common/logout',
                'common/forgotten',
                'common/reset',
                'error/not_found',
            );

            $config_ignore = array();

            if ($this->config->get('config_token_ignore')) {
                $config_ignore = unserialize($this->config->get('config_token_ignore'));
            }

            $ignore = array_merge($ignore, $config_ignore);

            if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
                return $this->forward('common/login');
            }
        } else {
            if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
                return $this->forward('common/login');
            }
        }
    }

}

