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

class ControllerCommonDashboard extends Controller {

	public function index(){

		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));


		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/dashboard.tpl', $data));
	}

	public function control(){

		$this->load->language('common/control');

		$data['text_balance'] = $this->language->get('text_balance');
		$data['text_available'] = sprintf($this->language->get('text_available'),$this->currency->format($this->account->getBalance(), $this->currency->getCode(), 1,true,false));

		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_withdraw'] = $this->language->get('button_withdraw');
		$data['button_send_money'] = $this->language->get('button_send_money');

		$data['balance'] = $this->account->getBalance();
		$data['min_transfer'] = $this->config->get('config_min_transfer');
		$data['min_withdraw'] = $this->config->get('config_min_withdraw');
		$data['livemode'] = $this->account->getMode();

		$data['upload'] = $this->url->link('fund/upload','token='.$this->session->data['token'],'SSL');
		$data['send'] = $this->url->link('fund/send','token='.$this->session->data['token'],'SSL');
		$data['withdraw'] = $this->url->link('fund/withdraw','token='.$this->session->data['token'],'SSL');


		$this->response->setOutput($this->load->view('common/control.tpl', $data));
	}
}