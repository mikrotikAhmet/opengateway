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

        $this->load->model('account/customer');
        $this->load->model('tool/image');
        $this->load->model('opengateway/setting');

        $customer_cards = $this->model_account_customer->getCards();

        foreach ($customer_cards as $customer_card) {
            $this->data['cards'][] = array(
                'customer_card_id' => $customer_card['customer_card_id'],
                'type' => $customer_card['type'],
                'card_number' => $customer_card['card_number'],
                'cardholder' => $customer_card['cardholder'],
                'image' => $this->model_tool_image->resize($customer_card['image'], 40, 40)
            );
        }

        $this->data['back'] = $this->url->link('account/deposit', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'account/deposit_card.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function getBanks() {

        $this->load->model('opengateway/setting');

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
                'reference' => sprintf($this->language->get('text_reference_info'), $this->customer->getId())
            );
        }



        $this->template = 'opengateway/banks.tpl';

        $this->response->setOutput($this->render());
    }

}

