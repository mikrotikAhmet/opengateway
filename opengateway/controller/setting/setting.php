<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/3/15
 * Time: 8:43 AM
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

class ControllerSettingSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post);

			if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency');

				$this->model_localisation_currency->updateCurrencies();
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('setting/application', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_select'] = $this->language->get('text_select');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_mail'] = $this->language->get('text_mail');
		$data['text_smtp'] = $this->language->get('text_smtp');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_gateway_pagination'] = $this->language->get('text_gateway_pagination');
		$data['text_channel'] = $this->language->get('text_channel');
		$data['text_mpi'] = $this->language->get('text_mpi');
		$data['text_charge'] = $this->language->get('text_charge');
		$data['text_deposit'] = $this->language->get('text_deposit');
		$data['text_withdraw'] = $this->language->get('text_withdraw');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_owner'] = $this->language->get('entry_owner');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_geocode'] = $this->language->get('entry_geocode');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_open'] = $this->language->get('entry_open');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$data['entry_item_limit'] = $this->language->get('entry_item_limit');
		$data['entry_limit_admin'] = $this->language->get('entry_limit_admin');
		$data['entry_account_online'] = $this->language->get('entry_account_online');
		$data['entry_account_group'] = $this->language->get('entry_account_group');
		$data['entry_account_group_display'] = $this->language->get('entry_account_group_display');
		$data['entry_account_mail'] = $this->language->get('entry_account_mail');
		$data['entry_channel'] = $this->language->get('entry_channel');
		$data['entry_amex_channel'] = $this->language->get('entry_amex_channel');
		$data['entry_mpi'] = $this->language->get('entry_mpi');
		$data['entry_min_transfer'] = $this->language->get('entry_min_transfer');
		$data['entry_max_transfer'] = $this->language->get('entry_max_transfer');
		$data['entry_transfer_fee'] = $this->language->get('entry_transfer_fee');
		$data['entry_transfer_percent'] = $this->language->get('entry_transfer_percent');
		$data['entry_refund_period'] = $this->language->get('entry_refund_period');
		$data['entry_min_deposit'] = $this->language->get('entry_min_deposit');
		$data['entry_max_deposit'] = $this->language->get('entry_max_deposit');
		$data['entry_min_withdraw'] = $this->language->get('entry_min_withdraw');
		$data['entry_max_withdraw'] = $this->language->get('entry_max_withdraw');
		$data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_icon'] = $this->language->get('entry_icon');
		$data['entry_image_category'] = $this->language->get('entry_image_category');
		$data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$data['entry_image_popup'] = $this->language->get('entry_image_popup');
		$data['entry_image_product'] = $this->language->get('entry_image_product');
		$data['entry_image_additional'] = $this->language->get('entry_image_additional');
		$data['entry_image_related'] = $this->language->get('entry_image_related');
		$data['entry_image_compare'] = $this->language->get('entry_image_compare');
		$data['entry_image_wishlist'] = $this->language->get('entry_image_wishlist');
		$data['entry_image_cart'] = $this->language->get('entry_image_cart');
		$data['entry_image_location'] = $this->language->get('entry_image_location');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_ftp_hostname'] = $this->language->get('entry_ftp_hostname');
		$data['entry_ftp_port'] = $this->language->get('entry_ftp_port');
		$data['entry_ftp_username'] = $this->language->get('entry_ftp_username');
		$data['entry_ftp_password'] = $this->language->get('entry_ftp_password');
		$data['entry_ftp_root'] = $this->language->get('entry_ftp_root');
		$data['entry_ftp_status'] = $this->language->get('entry_ftp_status');
		$data['entry_mail_alert'] = $this->language->get('entry_mail_alert');
		$data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$data['entry_smtp_hostname'] = $this->language->get('entry_smtp_hostname');
		$data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$data['entry_mail_alert'] = $this->language->get('entry_mail_alert');
		$data['entry_fraud_detection'] = $this->language->get('entry_fraud_detection');
		$data['entry_fraud_key'] = $this->language->get('entry_fraud_key');
		$data['entry_fraud_score'] = $this->language->get('entry_fraud_score');
		$data['entry_fraud_status'] = $this->language->get('entry_fraud_status');
		$data['entry_secure'] = $this->language->get('entry_secure');
		$data['entry_shared'] = $this->language->get('entry_shared');
		$data['entry_robots'] = $this->language->get('entry_robots');
		$data['entry_file_max_size'] = $this->language->get('entry_file_max_size');
		$data['entry_file_ext_allowed'] = $this->language->get('entry_file_ext_allowed');
		$data['entry_file_mime_allowed'] = $this->language->get('entry_file_mime_allowed');
		$data['entry_maintenance'] = $this->language->get('entry_maintenance');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_encryption'] = $this->language->get('entry_encryption');
		$data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$data['entry_compression'] = $this->language->get('entry_compression');
		$data['entry_error_display'] = $this->language->get('entry_error_display');
		$data['entry_error_log'] = $this->language->get('entry_error_log');
		$data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$data['entry_google_analytics'] = $this->language->get('entry_google_analytics');

		$data['help_geocode'] = $this->language->get('help_geocode');
		$data['help_location'] = $this->language->get('help_location');
		$data['help_currency'] = $this->language->get('help_currency');
		$data['help_currency_auto'] = $this->language->get('help_currency_auto');
		$data['help_item_limit'] = $this->language->get('help_item_limit');
		$data['help_limit_admin'] = $this->language->get('help_limit_admin');
		$data['help_account_online'] = $this->language->get('help_account_online');
		$data['help_account_group'] = $this->language->get('help_account_group');
		$data['help_account_group_display'] = $this->language->get('help_account_group_display');
		$data['help_account_mail'] = $this->language->get('help_account_mail');
		$data['help_dynamic_descriptor'] = $this->language->get('help_dynamic_descriptor');
		$data['help_channel'] = $this->language->get('help_channel');
		$data['help_amex_channel'] = $this->language->get('help_amex_channel');
		$data['help_mpi'] = $this->language->get('help_mpi');
		$data['help_min_transfer'] = $this->language->get('help_min_transfer');
		$data['help_max_transfer'] = $this->language->get('help_max_transfer');
		$data['help_transfer_fee'] = $this->language->get('help_transfer_fee');
		$data['help_transfer_percent'] = $this->language->get('help_transfer_percent');
		$data['help_refund_period'] = $this->language->get('help_refund_period');
		$data['help_min_deposit'] = $this->language->get('help_min_deposit');
		$data['help_max_deposit'] = $this->language->get('help_max_deposit');
		$data['help_min_withdraw'] = $this->language->get('help_min_withdraw');
		$data['help_max_withdraw'] = $this->language->get('help_max_withdraw');
		$data['help_icon'] = $this->language->get('help_icon');
		$data['help_ftp_root'] = $this->language->get('help_ftp_root');
		$data['help_mail_protocol'] = $this->language->get('help_mail_protocol');
		$data['help_mail_parameter'] = $this->language->get('help_mail_parameter');
		$data['help_mail_smtp_hostname'] = $this->language->get('help_mail_smtp_hostname');
		$data['help_mail_alert'] = $this->language->get('help_mail_alert');
		$data['help_fraud_detection'] = $this->language->get('help_fraud_detection');
		$data['help_fraud_score'] = $this->language->get('help_fraud_score');
		$data['help_fraud_status'] = $this->language->get('help_fraud_status');
		$data['help_secure'] = $this->language->get('help_secure');
		$data['help_shared'] = $this->language->get('help_shared');
		$data['help_robots'] = $this->language->get('help_robots');
		$data['help_seo_url'] = $this->language->get('help_seo_url');
		$data['help_file_max_size'] = $this->language->get('help_file_max_size');
		$data['help_file_ext_allowed'] = $this->language->get('help_file_ext_allowed');
		$data['help_file_mime_allowed'] = $this->language->get('help_file_mime_allowed');
		$data['help_maintenance'] = $this->language->get('help_maintenance');
		$data['help_password'] = $this->language->get('help_password');
		$data['help_encryption'] = $this->language->get('help_encryption');
		$data['help_compression'] = $this->language->get('help_compression');
		$data['help_google_analytics'] = $this->language->get('help_google_analytics');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_application'] = $this->language->get('tab_application');
		$data['tab_local'] = $this->language->get('tab_local');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_gateway'] = $this->language->get('tab_gateway');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_ftp'] = $this->language->get('tab_ftp');
		$data['tab_mail'] = $this->language->get('tab_mail');
		$data['tab_fraud'] = $this->language->get('tab_fraud');
		$data['tab_server'] = $this->language->get('tab_server');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['owner'])) {
			$data['error_owner'] = $this->error['owner'];
		} else {
			$data['error_owner'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['account_group_display'])) {
			$data['error_account_group_display'] = $this->error['account_group_display'];
		} else {
			$data['error_account_group_display'] = '';
		}

		if (isset($this->error['min_transfer'])) {
			$data['error_min_transfer'] = $this->error['min_transfer'];
		} else {
			$data['error_min_transfer'] = '';
		}

		if (isset($this->error['max_transfer'])) {
			$data['error_max_transfer'] = $this->error['max_transfer'];
		} else {
			$data['error_max_transfer'] = '';
		}

		if (isset($this->error['transfer_fee'])) {
			$data['error_transfer_fee'] = $this->error['transfer_fee'];
		} else {
			$data['error_transfer_fee'] = '';
		}

		if (isset($this->error['transfer_percent'])) {
			$data['error_transfer_percent'] = $this->error['transfer_percent'];
		} else {
			$data['error_transfer_percent'] = '';
		}

		if (isset($this->error['refund_period'])) {
			$data['error_refund_period'] = $this->error['refund_period'];
		} else {
			$data['error_refund_period'] = '';
		}

		if (isset($this->error['min_deposit'])) {
			$data['error_min_deposit'] = $this->error['min_deposit'];
		} else {
			$data['error_min_deposit'] = '';
		}

		if (isset($this->error['max_deposit'])) {
			$data['error_max_deposit'] = $this->error['max_deposit'];
		} else {
			$data['error_max_deposit'] = '';
		}

		if (isset($this->error['min_withdraw'])) {
			$data['error_min_withdraw'] = $this->error['min_withdraw'];
		} else {
			$data['error_min_withdraw'] = '';
		}

		if (isset($this->error['max_withdraw'])) {
			$data['error_max_withdraw'] = $this->error['max_withdraw'];
		} else {
			$data['error_max_withdraw'] = '';
		}

		if (isset($this->error['ftp_hostname'])) {
			$data['error_ftp_hostname'] = $this->error['ftp_hostname'];
		} else {
			$data['error_ftp_hostname'] = '';
		}

		if (isset($this->error['ftp_port'])) {
			$data['error_ftp_port'] = $this->error['ftp_port'];
		} else {
			$data['error_ftp_port'] = '';
		}

		if (isset($this->error['ftp_username'])) {
			$data['error_ftp_username'] = $this->error['ftp_username'];
		} else {
			$data['error_ftp_username'] = '';
		}

		if (isset($this->error['ftp_password'])) {
			$data['error_ftp_password'] = $this->error['ftp_password'];
		} else {
			$data['error_ftp_password'] = '';
		}

		if (isset($this->error['image_location'])) {
			$data['error_image_location'] = $this->error['image_location'];
		} else {
			$data['error_image_location'] = '';
		}

		if (isset($this->error['error_filename'])) {
			$data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$data['error_error_filename'] = '';
		}

		if (isset($this->error['item_limit'])) {
			$data['error_item_limit'] = $this->error['item_limit'];
		} else {
			$data['error_item_limit'] = '';
		}

		if (isset($this->error['limit_admin'])) {
			$data['error_limit_admin'] = $this->error['limit_admin'];
		} else {
			$data['error_limit_admin'] = '';
		}

		if (isset($this->error['encryption'])) {
			$data['error_encryption'] = $this->error['encryption'];
		} else {
			$data['error_encryption'] = '';
		}



		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('setting/application', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['config_name'])) {
			$data['config_name'] = $this->request->post['config_name'];
		} else {
			$data['config_name'] = $this->config->get('config_name');
		}

		if (isset($this->request->post['config_owner'])) {
			$data['config_owner'] = $this->request->post['config_owner'];
		} else {
			$data['config_owner'] = $this->config->get('config_owner');
		}

		if (isset($this->request->post['config_address'])) {
			$data['config_address'] = $this->request->post['config_address'];
		} else {
			$data['config_address'] = $this->config->get('config_address');
		}

		if (isset($this->request->post['config_geocode'])) {
			$data['config_geocode'] = $this->request->post['config_geocode'];
		} else {
			$data['config_geocode'] = $this->config->get('config_geocode');
		}

		if (isset($this->request->post['config_email'])) {
			$data['config_email'] = $this->request->post['config_email'];
		} else {
			$data['config_email'] = $this->config->get('config_email');
		}

		if (isset($this->request->post['config_telephone'])) {
			$data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_fax'])) {
			$data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$data['config_fax'] = $this->config->get('config_fax');
		}

		$this->load->model('localisation/location');

		$data['locations'] = $this->model_localisation_location->getLocations();

		if (isset($this->request->post['config_location'])) {
			$data['config_location'] = $this->request->post['config_location'];
		} elseif ($this->config->get('config_location')) {
			$data['config_location'] = $this->config->get('config_location');
		} else {
			$data['config_location'] = array();
		}

		if (isset($this->request->post['config_meta_title'])) {
			$data['config_meta_title'] = $this->request->post['config_meta_title'];
		} else {
			$data['config_meta_title'] = $this->config->get('config_meta_title');
		}

		if (isset($this->request->post['config_meta_description'])) {
			$data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$data['config_meta_description'] = $this->config->get('config_meta_description');
		}

		if (isset($this->request->post['config_meta_keyword'])) {
			$data['config_meta_keyword'] = $this->request->post['config_meta_keyword'];
		} else {
			$data['config_meta_keyword'] = $this->config->get('config_meta_keyword');
		}

		if (isset($this->request->post['config_template'])) {
			$data['config_template'] = $this->request->post['config_template'];
		} else {
			$data['config_template'] = $this->config->get('config_template');
		}

		$data['templates'] = array();

		$directories = glob(DIR_PORTAL. 'view/theme/*', GLOB_ONLYDIR);

		foreach ($directories as $directory) {
			$data['templates'][] = basename($directory);
		}

		if (isset($this->request->post['config_country_id'])) {
			$data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$data['config_country_id'] = $this->config->get('config_country_id');
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['config_zone_id'])) {
			$data['config_zone_id'] = $this->request->post['config_zone_id'];
		} else {
			$data['config_zone_id'] = $this->config->get('config_zone_id');
		}

		if (isset($this->request->post['config_language'])) {
			$data['config_language'] = $this->request->post['config_language'];
		} else {
			$data['config_language'] = $this->config->get('config_language');
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['config_admin_language'])) {
			$data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$data['config_admin_language'] = $this->config->get('config_admin_language');
		}

		if (isset($this->request->post['config_currency'])) {
			$data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$data['config_currency'] = $this->config->get('config_currency');
		}

		if (isset($this->request->post['config_currency_auto'])) {
			$data['config_currency_auto'] = $this->request->post['config_currency_auto'];
		} else {
			$data['config_currency_auto'] = $this->config->get('config_currency_auto');
		}

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		if (isset($this->request->post['config_item_limit'])) {
			$data['config_item_limit'] = $this->request->post['config_item_limit'];
		} else {
			$data['config_item_limit'] = $this->config->get('config_item_limit');
		}

		if (isset($this->request->post['config_limit_admin'])) {
			$data['config_limit_admin'] = $this->request->post['config_limit_admin'];
		} else {
			$data['config_limit_admin'] = $this->config->get('config_limit_admin');
		}

		if (isset($this->request->post['config_account_online'])) {
			$data['config_account_online'] = $this->request->post['config_account_online'];
		} else {
			$data['config_account_online'] = $this->config->get('config_account_online');
		}

		if (isset($this->request->post['config_account_group_id'])) {
			$data['config_account_group_id'] = $this->request->post['config_account_group_id'];
		} else {
			$data['config_account_group_id'] = $this->config->get('config_account_group_id');
		}

		$this->load->model('account/account_group');

		$data['account_groups'] = $this->model_account_account_group->getAccountGroups();

		if (isset($this->request->post['config_account_group_display'])) {
			$data['config_account_group_display'] = $this->request->post['config_account_group_display'];
		} elseif ($this->config->get('config_account_group_display')) {
			$data['config_account_group_display'] = $this->config->get('config_account_group_display');
		} else {
			$data['config_account_group_display'] = array();
		}

		if (isset($this->request->post['config_account_mail'])) {
			$data['config_account_mail'] = $this->request->post['config_account_mail'];
		} else {
			$data['config_account_mail'] = $this->config->get('config_account_mail');
		}

		if (isset($this->request->post['config_channel_id'])) {
			$data['config_channel_id'] = $this->request->post['config_channel_id'];
		} else {
			$data['config_channel_id'] = $this->config->get('config_channel_id');
		}

		if (isset($this->request->post['config_amex_channel_id'])) {
			$data['config_amex_channel_id'] = $this->request->post['config_amex_channel_id'];
		} else {
			$data['config_amex_channel_id'] = $this->config->get('config_amex_channel_id');
		}

		$this->load->model('setting/psp');

		$data['psps'] = $this->model_setting_psp->getPsps();


		if (isset($this->request->post['config_mpi'])) {
			$data['config_mpi'] = $this->request->post['config_mpi'];
		} else {
			$data['config_mpi'] = $this->config->get('config_mpi');
		}

		if (isset($this->request->post['config_min_transfer'])) {
			$data['config_min_transfer'] = $this->request->post['config_min_transfer'];
		} else {
			$data['config_min_transfer'] = $this->config->get('config_min_transfer');
		}

		if (isset($this->request->post['config_max_transfer'])) {
			$data['config_max_transfer'] = $this->request->post['config_max_transfer'];
		} else {
			$data['config_max_transfer'] = $this->config->get('config_max_transfer');
		}

		if (isset($this->request->post['config_transfer_fee'])) {
			$data['config_transfer_fee'] = $this->request->post['config_transfer_fee'];
		} else {
			$data['config_transfer_fee'] = $this->config->get('config_transfer_fee');
		}

		if (isset($this->request->post['config_transfer_percent'])) {
			$data['config_transfer_percent'] = $this->request->post['config_transfer_percent'];
		} else {
			$data['config_transfer_percent'] = $this->config->get('config_transfer_percent');
		}

		if (isset($this->request->post['config_refund_period'])) {
			$data['config_refund_period'] = $this->request->post['config_refund_period'];
		} else {
			$data['config_refund_period'] = $this->config->get('config_refund_period');
		}

		if (isset($this->request->post['config_min_deposit'])) {
			$data['config_min_deposit'] = $this->request->post['config_min_deposit'];
		} else {
			$data['config_min_deposit'] = $this->config->get('config_min_deposit');
		}

		if (isset($this->request->post['config_max_deposit'])) {
			$data['config_max_deposit'] = $this->request->post['config_max_deposit'];
		} else {
			$data['config_max_deposit'] = $this->config->get('config_max_deposit');
		}

		if (isset($this->request->post['config_min_withdraw'])) {
			$data['config_min_withdraw'] = $this->request->post['config_min_withdraw'];
		} else {
			$data['config_min_withdraw'] = $this->config->get('config_min_withdraw');
		}

		if (isset($this->request->post['config_max_withdraw'])) {
			$data['config_max_withdraw'] = $this->request->post['config_max_withdraw'];
		} else {
			$data['config_max_withdraw'] = $this->config->get('config_max_withdraw');
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['config_logo'])) {
			$data['config_logo'] = $this->request->post['config_logo'];
		} else {
			$data['config_logo'] = $this->config->get('config_logo');
		}

		if (isset($this->request->post['config_logo']) && is_file(DIR_IMAGE . $this->request->post['config_logo'])) {
			$data['logo'] = $this->model_tool_image->resize($this->request->post['config_logo'], 100, 100);
		} elseif ($this->config->get('config_logo') && is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
		} else {
			$data['logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['config_icon'])) {
			$data['config_icon'] = $this->request->post['config_icon'];
		} else {
			$data['config_icon'] = $this->config->get('config_icon');
		}

		if (isset($this->request->post['config_icon']) && is_file(DIR_IMAGE . $this->request->post['config_icon'])) {
			$data['icon'] = $this->model_tool_image->resize($this->request->post['config_logo'], 100, 100);
		} elseif ($this->config->get('config_icon') && is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $this->model_tool_image->resize($this->config->get('config_icon'), 100, 100);
		} else {
			$data['icon'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['config_ftp_hostname'])) {
			$data['config_ftp_hostname'] = $this->request->post['config_ftp_hostname'];
		} elseif ($this->config->get('config_ftp_hostname')) {
			$data['config_ftp_hostname'] = $this->config->get('config_ftp_hostname');
		} else {
			$data['config_ftp_hostname'] = str_replace('www.', '', $this->request->server['HTTP_HOST']);
		}

		if (isset($this->request->post['config_ftp_port'])) {
			$data['config_ftp_port'] = $this->request->post['config_ftp_port'];
		} elseif ($this->config->get('config_ftp_port')) {
			$data['config_ftp_port'] = $this->config->get('config_ftp_port');
		} else {
			$data['config_ftp_port'] = 21;
		}

		if (isset($this->request->post['config_ftp_username'])) {
			$data['config_ftp_username'] = $this->request->post['config_ftp_username'];
		} else {
			$data['config_ftp_username'] = $this->config->get('config_ftp_username');
		}

		if (isset($this->request->post['config_ftp_password'])) {
			$data['config_ftp_password'] = $this->request->post['config_ftp_password'];
		} else {
			$data['config_ftp_password'] = $this->config->get('config_ftp_password');
		}

		if (isset($this->request->post['config_ftp_root'])) {
			$data['config_ftp_root'] = $this->request->post['config_ftp_root'];
		} else {
			$data['config_ftp_root'] = $this->config->get('config_ftp_root');
		}

		if (isset($this->request->post['config_ftp_status'])) {
			$data['config_ftp_status'] = $this->request->post['config_ftp_status'];
		} else {
			$data['config_ftp_status'] = $this->config->get('config_ftp_status');
		}

		if (isset($this->request->post['config_mail'])) {
			$config_mail = $this->request->post['config_mail'];

			$data['config_mail_protocol'] = $config_mail['protocol'];
			$data['config_mail_parameter'] = $config_mail['parameter'];
			$data['config_smtp_hostname'] = $config_mail['smtp_hostname'];
			$data['config_smtp_username'] = $config_mail['smtp_username'];
			$data['config_smtp_password'] = $config_mail['smtp_password'];
			$data['config_smtp_port'] = $config_mail['smtp_port'];
			$data['config_smtp_timeout'] = $config_mail['smtp_timeout'];
		} elseif ($this->config->get('config_mail')) {
			$config_mail = $this->config->get('config_mail');

			$data['config_mail_protocol'] = $config_mail['protocol'];
			$data['config_mail_parameter'] = $config_mail['parameter'];
			$data['config_smtp_hostname'] = $config_mail['smtp_hostname'];
			$data['config_smtp_username'] = $config_mail['smtp_username'];
			$data['config_smtp_password'] = $config_mail['smtp_password'];
			$data['config_smtp_port'] = $config_mail['smtp_port'];
			$data['config_smtp_timeout'] = $config_mail['smtp_timeout'];
		} else {
			$data['config_mail_protocol'] = '';
			$data['config_mail_parameter'] = '';
			$data['config_smtp_hostname'] = '';
			$data['config_smtp_username'] = '';
			$data['config_smtp_password'] = '';
			$data['config_smtp_port'] = 25;
			$data['config_smtp_timeout'] = 5;
		}

		if (isset($this->request->post['config_mail_alert'])) {
			$data['config_mail_alert'] = $this->request->post['config_mail_alert'];
		} else {
			$data['config_mail_alert'] = $this->config->get('config_mail_alert');
		}

		if (isset($this->request->post['config_fraud_detection'])) {
			$data['config_fraud_detection'] = $this->request->post['config_fraud_detection'];
		} else {
			$data['config_fraud_detection'] = $this->config->get('config_fraud_detection');
		}

		if (isset($this->request->post['config_fraud_key'])) {
			$data['config_fraud_key'] = $this->request->post['config_fraud_key'];
		} else {
			$data['config_fraud_key'] = $this->config->get('config_fraud_key');
		}

		if (isset($this->request->post['config_fraud_score'])) {
			$data['config_fraud_score'] = $this->request->post['config_fraud_score'];
		} else {
			$data['config_fraud_score'] = $this->config->get('config_fraud_score');
		}

		if (isset($this->request->post['config_fraud_status_id'])) {
			$data['config_fraud_status_id'] = $this->request->post['config_fraud_status_id'];
		} else {
			$data['config_fraud_status_id'] = $this->config->get('config_fraud_status_id');
		}

		if (isset($this->request->post['config_secure'])) {
			$data['config_secure'] = $this->request->post['config_secure'];
		} else {
			$data['config_secure'] = $this->config->get('config_secure');
		}

		if (isset($this->request->post['config_shared'])) {
			$data['config_shared'] = $this->request->post['config_shared'];
		} else {
			$data['config_shared'] = $this->config->get('config_shared');
		}

		if (isset($this->request->post['config_robots'])) {
			$data['config_robots'] = $this->request->post['config_robots'];
		} else {
			$data['config_robots'] = $this->config->get('config_robots');
		}

		if (isset($this->request->post['config_seo_url'])) {
			$data['config_seo_url'] = $this->request->post['config_seo_url'];
		} else {
			$data['config_seo_url'] = $this->config->get('config_seo_url');
		}

		if (isset($this->request->post['config_file_max_size'])) {
			$data['config_file_max_size'] = $this->request->post['config_file_max_size'];
		} elseif ($this->config->get('config_file_max_size')) {
			$data['config_file_max_size'] = $this->config->get('config_file_max_size');
		} else {
			$data['config_file_max_size'] = 300000;
		}

		if (isset($this->request->post['config_file_ext_allowed'])) {
			$data['config_file_ext_allowed'] = $this->request->post['config_file_ext_allowed'];
		} else {
			$data['config_file_ext_allowed'] = $this->config->get('config_file_ext_allowed');
		}

		if (isset($this->request->post['config_file_mime_allowed'])) {
			$data['config_file_mime_allowed'] = $this->request->post['config_file_mime_allowed'];
		} else {
			$data['config_file_mime_allowed'] = $this->config->get('config_file_mime_allowed');
		}

		if (isset($this->request->post['config_maintenance'])) {
			$data['config_maintenance'] = $this->request->post['config_maintenance'];
		} else {
			$data['config_maintenance'] = $this->config->get('config_maintenance');
		}

		if (isset($this->request->post['config_password'])) {
			$data['config_password'] = $this->request->post['config_password'];
		} else {
			$data['config_password'] = $this->config->get('config_password');
		}

		if (isset($this->request->post['config_encryption'])) {
			$data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$data['config_encryption'] = $this->config->get('config_encryption');
		}

		if (isset($this->request->post['config_compression'])) {
			$data['config_compression'] = $this->request->post['config_compression'];
		} else {
			$data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$data['config_error_display'] = $this->request->post['config_error_display'];
		} else {
			$data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$data['config_error_log'] = $this->request->post['config_error_log'];
		} else {
			$data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$data['config_error_filename'] = $this->request->post['config_error_filename'];
		} else {
			$data['config_error_filename'] = $this->config->get('config_error_filename');
		}

		if (isset($this->request->post['config_google_analytics'])) {
			$data['config_google_analytics'] = $this->request->post['config_google_analytics'];
		} else {
			$data['config_google_analytics'] = $this->config->get('config_google_analytics');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/setting.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_name']) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['config_owner']) < 3) || (utf8_strlen($this->request->post['config_owner']) > 64)) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		if ((utf8_strlen($this->request->post['config_address']) < 3) || (utf8_strlen($this->request->post['config_address']) > 256)) {
			$this->error['address'] = $this->language->get('error_address');
		}

		if ((utf8_strlen($this->request->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['config_email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['config_telephone']) < 3) || (utf8_strlen($this->request->post['config_telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (!$this->request->post['config_meta_title']) {
			$this->error['meta_title'] = $this->language->get('error_meta_title');
		}

		if (!$this->request->post['config_min_transfer']) {
			$this->error['min_transfer'] = $this->language->get('error_min_transfer');
		}

		if (!$this->request->post['config_max_transfer']) {
			$this->error['max_transfer'] = $this->language->get('error_max_transfer');
		}

		if (!$this->request->post['config_transfer_fee']) {
			$this->error['transfer_fee'] = $this->language->get('error_transfer_fee');
		}

		if (!$this->request->post['config_transfer_percent']) {
			$this->error['transfer_percent'] = $this->language->get('error_transfer_percent');
		}

		if (!$this->request->post['config_refund_period']) {
			$this->error['refund_period'] = $this->language->get('error_refund_period');
		}

		if (!$this->request->post['config_min_deposit']) {
			$this->error['min_deposit'] = $this->language->get('error_min_deposit');
		}

		if (!$this->request->post['config_max_deposit']) {
			$this->error['max_deposit'] = $this->language->get('error_max_deposit');
		}

		if (!$this->request->post['config_min_withdraw']) {
			$this->error['min_withdraw'] = $this->language->get('error_min_withdraw');
		}

		if (!$this->request->post['config_max_withdraw']) {
			$this->error['max_withdraw'] = $this->language->get('error_max_withdraw');
		}

		if ($this->request->post['config_ftp_status']) {
			if (!$this->request->post['config_ftp_hostname']) {
				$this->error['ftp_hostname'] = $this->language->get('error_ftp_hostname');
			}

			if (!$this->request->post['config_ftp_port']) {
				$this->error['ftp_port'] = $this->language->get('error_ftp_port');
			}

			if (!$this->request->post['config_ftp_username']) {
				$this->error['ftp_username'] = $this->language->get('error_ftp_username');
			}

			if (!$this->request->post['config_ftp_password']) {
				$this->error['ftp_password'] = $this->language->get('error_ftp_password');
			}
		}

		if (!$this->request->post['config_error_filename']) {
			$this->error['error_error_filename'] = $this->language->get('error_error_filename');
		}

		if (!$this->request->post['config_item_limit']) {
			$this->error['item_limit'] = $this->language->get('error_limit');
		}


		if (!$this->request->post['config_limit_admin']) {
			$this->error['limit_admin'] = $this->language->get('error_limit');
		}

		if ((utf8_strlen($this->request->post['config_encryption']) < 3) || (utf8_strlen($this->request->post['config_encryption']) > 32)) {
			$this->error['encryption'] = $this->language->get('error_encryption');
		}


		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function template() {
		if ($this->request->server['HTTPS']) {
			$server = HTTPS_SERVER;
		} else {
			$server = HTTP_SERVER;
		}

		if (is_file(DIR_IMAGE . 'templates/' . basename($this->request->get['template']) . '.png')) {
			$this->response->setOutput($server . 'image/templates/' . basename($this->request->get['template']) . '.png');
		} else {
			$this->response->setOutput($server . 'image/no_image.png');
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
} 