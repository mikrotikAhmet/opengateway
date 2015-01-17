<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/2/15
 * Time: 4:29 PM
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

class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_suit'] = $this->language->get('text_suit');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_account_group'] = $this->language->get('text_account_group');
		$data['text_system'] = $this->language->get('text_system');
		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');
		$data['text_users'] = $this->language->get('text_users');

		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$data['account'] = $this->url->link('account/account', 'token=' . $this->session->data['token'], 'SSL');
		$data['account_group'] = $this->url->link('account/account_group', 'token=' . $this->session->data['token'], 'SSL');
		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');


		return $this->load->view('common/menu.tpl', $data);
	}
}