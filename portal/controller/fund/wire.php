<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/4/15
 * Time: 8:33 PM
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

class ControllerFundWire extends Controller {

	public function index(){

		$this->load->language('fund/wire');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_upload_step_2'] = $this->language->get('text_upload_step_2');

		$data['text_upload_step_2_1'] = $this->language->get('text_upload_step_2_1');
		$data['text_upload_step_2_2'] = $this->language->get('text_upload_step_2_2');


		$this->load->model('account/account_group');

		$account_group_info = $this->model_account_account_group->getAccountGroup($this->account->getAccountGroupId());

		if ($account_group_info['personal']){
			$data['text_withdraw_information'] = sprintf($this->language->get('text_withdraw_personal'),$this->account->getFirstName().' '.strtoupper($this->account->getLastName()));
		} elseif ($account_group_info['business']){
			$data['text_withdraw_information'] = sprintf($this->language->get('text_withdraw_business'),$this->account->getFirstName().' '.strtoupper($this->account->getLastName()),'Semite LLC');
		}

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['button_back'] = $this->language->get('button_back');

		$data['back'] = $this->url->link('fund/upload','token='.$this->session->data['token'],'SSL');

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('fund/wire.tpl', $data));
	}

	public function banks(){

		$this->load->language('fund/wire');

		$data['text_no_bank_information'] = $this->language->get('text_no_bank_information');
		$data['text_account_holder'] = $this->language->get('text_account_holder');
		$data['text_account_bank'] = $this->language->get('text_account_bank');
		$data['text_account_city'] = $this->language->get('text_account_city');
		$data['text_account_country'] = $this->language->get('text_account_country');
		$data['text_account_number'] = $this->language->get('text_account_number');
		$data['text_account_swift'] = $this->language->get('text_account_swift');
		$data['text_account_iban'] = $this->language->get('text_account_iban');
		$data['text_account_sort_code'] = $this->language->get('text_account_sort_code');
		$data['text_account_currency'] = $this->language->get('text_account_currency');
		$data['text_account_reference'] = $this->language->get('text_account_reference');
		$data['text_reference'] = sprintf($this->language->get('text_reference'), $this->account->getId());

		$currency_code = $this->request->post['currency_code'];

		$this->load->model('gateway/bank');

		$bank_info = $this->model_gateway_bank->getBank($currency_code);

		$data['bank'] = $bank_info;

		$data['name'] = $this->config->get('config_name');

		$this->response->setOutput($this->load->view('fund/bank_account_list.tpl', $data));
	}
} 