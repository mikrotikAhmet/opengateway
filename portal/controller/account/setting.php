<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/18/15
 * Time: 1:10 PM
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

class ControllerAccountSetting extends Controller {

	public function index(){
		$this->load->model('account/setting');

		$this->load->language('account/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getForm();
	}

	public function edit(){

		$this->load->model('account/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_account_setting->editAccount($this->account->getId(), $this->request->post);

			$this->response->redirect($this->url->link('account/setting', 'token=' . $this->session->data['token'] , 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		$data['text_api_access'] = $this->language->get('text_api_access');

		$data['warning_api_access'] = $this->language->get('warning_api_access');

		$data['entry_account_group'] = $this->language->get('entry_account_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');
		$data['entry_livemode'] = $this->language->get('entry_livemode');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_gmt_offset'] = $this->language->get('entry_gmt_offset');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_api_id'] = $this->language->get('entry_api_id');
		$data['entry_secret_key'] = $this->language->get('entry_secret_key');
		$data['entry_processor_id'] = $this->language->get('entry_processor_id');
		$data['entry_processor_guid'] = $this->language->get('entry_processor_guid');
		$data['entry_processor_id_amex'] = $this->language->get('entry_processor_id_amex');
		$data['entry_processor_guid_amex'] = $this->language->get('entry_processor_guid_amex');
		$data['entry_descriptor'] = $this->language->get('entry_descriptor');

		$data['help_live'] = $this->language->get('help_live');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_generate'] = $this->language->get('button_generate');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_address'] = $this->language->get('tab_address');
		$data['tab_login'] = $this->language->get('tab_login');
		$data['tab_api'] = $this->language->get('tab_api');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['account_id'])) {
			$data['account_id'] = $this->request->get['account_id'];
		} else {
			$data['account_id'] = $this->account->getId();
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}


		$data['action'] = $this->url->link('account/setting/edit', 'token=' . $this->session->data['token'] . '&account_id=' . $this->account->getId(), 'SSL');

		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

		if ($this->account->getId() && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$account_info = $this->model_account_setting->getAccount($this->account->getId());
		}

		$this->load->model('account/account_group');

		$data['account_group'] = $this->model_account_account_group->getAccountGroup($account_info['account_group_id']);

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($account_info)) {
			$data['firstname'] = $account_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($account_info)) {
			$data['lastname'] = $account_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($account_info)) {
			$data['email'] = $account_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($account_info)) {
			$data['telephone'] = $account_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['currency_code'])) {
			$data['currency_code'] = $this->request->post['currency_code'];
		} elseif (!empty($account_info)) {
			$data['currency_code'] = $account_info['currency_code'];
		} else {
			$data['currency_code'] = '';
		}

		if (isset($this->request->post['language_code'])) {
			$data['language_code'] = $this->request->post['language_code'];
		} elseif (!empty($account_info)) {
			$data['language_code'] = $account_info['language_code'];
		} else {
			$data['language_code'] = '';
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($account_info)) {
			$data['address_1'] = $account_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($account_info)) {
			$data['address_2'] = $account_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($account_info)) {
			$data['city'] = $account_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($account_info)) {
			$data['postcode'] = $account_info['postal_code'];
		} else {
			$data['postcode'] = '';
		}

			$this->load->model('localisation/country');

			$data['country'] = $this->model_localisation_country->getCountry($account_info['country_id']);

			$this->load->model('localisation/zone');

			$data['zone'] = $this->model_localisation_zone->getZone($account_info['zone_id']);

			$data['gmt_offset'] = $account_info['gmt_offset'];

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($account_info)) {
			$data['username'] = $account_info['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['descriptor'])) {
			$data['descriptor'] = $this->request->post['descriptor'];
		} elseif (!empty($account_info)) {
			$data['descriptor'] = $account_info['dynamicDescriptor'];
		} else {
			$data['descriptor'] = '';
		}


		if (isset($this->request->post['api_id'])) {
			$data['api_id'] = $this->request->post['api_id'];
		} elseif (!empty($account_info)) {
			$data['api_id'] = $account_info['api_id'];
		} else {
			$data['api_id'] = '';
		}

		if (isset($this->request->post['secret_key'])) {
			$data['secret_key'] = $this->request->post['secret_key'];
		} elseif (!empty($account_info)) {
			$data['secret_key'] = $account_info['api_secret'];
		} else {
			$data['secret_key'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/setting.tpl', $data));
	}

	public function generateKey() {

		sleep(1);

		$json = array();

		$v3id = strtoupper(UUID::random_key(10, $readable = true, $hash = true));
		$v3uuid = strtoupper(UUID::v3($this->config->get('config_encryption'), date('Ymd Hsi')));

		$json = array(
			'api_id'=>$v3id,
			'secret_key'=>$v3uuid
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validateForm() {


		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 255)) {
			$this->error['warning'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen($this->request->post['city']) < 3) || (utf8_strlen($this->request->post['city']) > 128)) {
			$this->error['warning'] = $this->language->get('error_city');
		}


		if ($this->request->post['password'] || (!isset($this->request->get['account_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['warning'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['warning'] = $this->language->get('error_confirm');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
} 