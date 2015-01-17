<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/4/15
 * Time: 7:37 PM
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

class ControllerFundUpload extends Controller {

	public function index(){

		$this->load->language('fund/upload');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_upload_step_1'] = $this->language->get('text_upload_step_1');
		$data['text_card'] = $this->language->get('text_card');
		$data['text_wire'] = $this->language->get('text_wire');
		$data['text_card_info'] = $this->language->get('text_card_info');
		$data['text_wire_info'] = $this->language->get('text_wire_info');

		$data['button_back'] = $this->language->get('button_back');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['back'] = $this->url->link('common/dashboard','token='.$this->session->data['token'],'SSL');
		$data['card'] = $this->url->link('fund/card','token='.$this->session->data['token'],'SSL');
		$data['wire'] = $this->url->link('fund/wire','token='.$this->session->data['token'],'SSL');

        $data['hasCard'] = $this->account->getCards();

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('fund/upload.tpl', $data));

	}
} 