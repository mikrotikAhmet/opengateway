<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 5:41 PM
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

class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->document->addScript('view/javascript/jquery/inputmask/js/jquery.mask.min.js');

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = HTTP_SERVER . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = HTTP_SERVER . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_feedback'] = $this->language->get('text_feedback');
		$data['text_overview'] = $this->language->get('text_overview');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_all_transaction'] = $this->language->get('text_all_transaction');
        $data['text_customer'] = $this->language->get('text_customer');
        $data['text_operation'] = $this->language->get('text_operation');
		$data['text_charge'] = $this->language->get('text_charge');
		$data['text_card_bank'] = $this->language->get('text_card_bank');
		$data['text_card'] = $this->language->get('text_card');
		$data['text_logout'] = $this->language->get('text_logout');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

		} else {
			$data['logged'] = true;
			$data['livemode'] = $this->account->getMode();

			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			$data['documentation'] = HTTP_APP.'api-docs/';
            $data['transaction'] = $this->url->link('report/transaction/allTransactions', 'token=' . $this->session->data['token'], 'SSL');
			$data['setting'] = $this->url->link('account/setting', 'token=' . $this->session->data['token'], 'SSL');
			$data['customer'] = $this->url->link('account/customer', 'token=' . $this->session->data['token'], 'SSL');
			$data['charge'] = $this->url->link('fund/charge', 'token=' . $this->session->data['token'], 'SSL');

			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

			$status = true;

			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

				foreach ($robots as $robot) {
					if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
						$status = false;

						break;
					}
				}
			}
		}

		$data['class'] = 'common-home';

		return $this->load->view('common/header.tpl', $data);
	}
}