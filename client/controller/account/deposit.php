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
 * @version     $Id: deposit.php Oct 4, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of deposit  Class
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

class ControllerAccountDeposit extends Controller {

    private $error = array();

    public function index() {

        $this->language->load('account/deposit');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_money_upload_step_1'] = $this->language->get('text_money_upload_step_1');
        $this->data['text_card_upload'] = $this->language->get('text_card_upload');
        $this->data['text_manual_upload'] = $this->language->get('text_manual_upload');
        $this->data['text_card_upload_info_1'] = $this->language->get('text_card_upload_info_1');
        $this->data['text_card_upload_info_2'] = $this->language->get('text_card_upload_info_2');
        $this->data['text_manual_upload_info_1'] = $this->language->get('text_manual_upload_info_1');

        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');

        $this->data['manual'] = $this->url->link('account/deposit/manual', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['card'] = $this->url->link('account/deposit/card', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'account/deposit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function manual() {

        $this->language->load('account/deposit_manual');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_select'] = $this->language->get('text_select');

        $this->data['text_manual_upload_step_2'] = $this->language->get('text_manual_upload_step_2');
        $this->data['text_manual_step_1'] = $this->language->get('text_manual_step_1');
        $this->data['text_manual_step_2'] = $this->language->get('text_manual_step_2');

        if ($this->customer->hasBusiness()) {
            $this->data['notice_manual_upload'] = sprintf($this->language->get('notice_manual_upload_1'), $this->customer->getUserName(), $this->customer->getBusinessName());
        } else {
            $this->data['notice_manual_upload'] = sprintf($this->language->get('notice_manual_upload_2'), $this->customer->getUserName());
        }

        $this->data['button_back'] = $this->language->get('button_back');

        $this->load->model('opengateway/setting');

        $this->data['currencies'] = $this->model_opengateway_setting->getAvailableCurrencies();

        $this->data['back'] = $this->url->link('account/deposit', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'account/deposit_manual.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function card() {

        $this->language->load('account/deposit_card');

        $this->load->model('tool/image');
        $this->load->model('opengateway/setting');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_amount_help'] = $this->language->get('text_amount_help');
        $this->data['text_card_upload_step_2'] = $this->language->get('text_card_upload_step_2');

        $this->data['entry_amount'] = $this->language->get('entry_amount');

        $this->data['error_no_card'] = sprintf($this->language->get('error_no_card'), $this->url->link('account/account', 'token=' . $this->session->data['token'], 'SSL'));

        $this->data['button_back'] = $this->language->get('button_back');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_add_card'] = $this->language->get('button_add_card');
        $this->data['notification_remove'] = $this->language->get('notification_remove');

        $this->data['back'] = $this->url->link('account/deposit', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }


        $this->data['action'] = $this->url->link('account/deposit/completepayment', 'token=' . $this->session->data['token'], 'SSL');

        // Get Customer Cards
        $api_response = $this->_api->apiGet('v1/customer/getCards');

        $data = json_decode($api_response);

        $this->data['cards'] = array();


        if ($data->status == "OK") {

            foreach ($data->data as $customer_card) {
                $this->data['cards'][] = array(
                    'customer_card_id' => $customer_card->customer_card_id,
                    'type' => $customer_card->type,
                    'card_number' => $customer_card->card_number,
                    'cardholder' => $customer_card->cardholder,
                    'image' => $this->model_tool_image->resize($customer_card->image, 40, 40)
                );
            }
        }

        $this->template = 'account/deposit_card.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function addcard() {

        $this->language->load('common/addcard');
        
        $this->data['entry_card_number'] = $this->language->get('entry_card_number');
        $this->data['entry_expiry'] = $this->language->get('entry_expiry');
        $this->data['entry_cvv'] = $this->language->get('entry_cvv');

        $this->data['button_back'] = $this->language->get('button_back');
        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['currentYear'] = date('Y');
        $this->data['currentMonth'] = date('m');

        $this->data['month_january'] = $this->language->get('month_january');
        $this->data['month_february'] = $this->language->get('month_february');
        $this->data['month_march'] = $this->language->get('month_march');
        $this->data['month_april'] = $this->language->get('month_april');
        $this->data['month_may'] = $this->language->get('month_may');
        $this->data['month_june'] = $this->language->get('month_june');
        $this->data['month_july'] = $this->language->get('month_july');
        $this->data['month_august'] = $this->language->get('month_august');
        $this->data['month_september'] = $this->language->get('month_september');
        $this->data['month_october'] = $this->language->get('month_october');
        $this->data['month_november'] = $this->language->get('month_november');
        $this->data['month_december'] = $this->language->get('month_december');
        
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        $this->template = 'common/addcard.tpl';

        $this->response->setOutput($this->render());
    }

    public function completepayment() {
        $this->language->load('account/deposit_card');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            // Make Deposit
            $api_response = $this->_api->apiPost('v1/payment/pay', $this->request->post);

            $data = json_decode($api_response);

            if ($data->status == "Accepted") {
                $this->redirect($this->url->link('account/deposit/success', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }

        $this->card();
    }

    public function getBanks() {

        $this->language->load('account/deposit_manual');

        $this->load->model('opengateway/setting');

        $this->data['text_account_holder'] = $this->language->get('text_account_holder');
        $this->data['text_bank'] = $this->language->get('text_bank');
        $this->data['text_zone'] = $this->language->get('text_zone');
        $this->data['text_country'] = $this->language->get('text_country');
        $this->data['text_account_number'] = $this->language->get('text_account_number');
        $this->data['text_swift'] = $this->language->get('text_swift');
        $this->data['text_iban'] = $this->language->get('text_iban');
        $this->data['text_sort_code'] = $this->language->get('text_sort_code');
        $this->data['text_currency'] = $this->language->get('text_currency');
        $this->data['text_reference'] = $this->language->get('text_reference');

        $currency_id = $this->request->get['currency_id'];

        $bank_info = $this->model_opengateway_setting->getBankByCurrencyId($currency_id);

        $this->data['bank'] = array();

        if ($bank_info) {

            $currency_info = $this->model_opengateway_setting->getCurrency($currency_id);
            $country_info = $this->model_opengateway_setting->getCountry($bank_info['country_id']);
            $zone_info = $this->model_opengateway_setting->getZone($bank_info['zone_id']);

            $this->data['bank'] = array(
                'account_holder' => $this->config->get('config_owner'),
                'bank' => $bank_info['bank'],
                'zone' => $zone_info['name'],
                'country' => $country_info['name'],
                'account_number' => $bank_info['account_number'],
                'swift' => $bank_info['swift'],
                'iban' => $bank_info['iban'],
                'sort_code' => $bank_info['sort_code'],
                'currency' => $currency_info['code'],
                'reference' => sprintf($this->language->get('text_reference_info'), $this->customer->getMerchantId())
            );
        }



        $this->template = 'opengateway/banks.tpl';

        $this->response->setOutput($this->render());
    }

    public function success() {

        $this->language->load('account/deposit_success');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['text_deposit_success'] = $this->language->get('text_deposit_success');
        $this->data['text_success_message'] = $this->language->get('text_success_message');

        $this->data['continue'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['button_continue'] = $this->language->get('button_continue');


        $this->template = 'account/deposit_success.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    
    public function validateCard(){
        
        $json = array();
        
        
        $this->response->setOutput(json_encode($json));
    }

    protected function validateForm() {

        if (utf8_strlen($this->request->post['amount']) < 2) {
            $this->error['warning'] = sprintf($this->language->get('error_amount'), $this->currency->format($this->config->get('config_mincard_deposit'), $this->config->get('config_currency')));
        }

        if (!isset($this->request->post['card']) || !$this->request->post['card']) {
            $this->error['warning'] = $this->language->get('error_card');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
