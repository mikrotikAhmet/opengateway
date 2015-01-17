<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2008 - 2015, Semite LLC.
 * @license		http://www.semitellc.com/user_guide/license.html
 * @link		http://www.semitellc.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * opengateway
 * Description of send.php Class
**/


class ControllerFundSend extends Controller {

    private $error = array();

    public function index(){


        $this->load->language('fund/send');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['text_attention'] = sprintf($this->language->get('text_attention'), $_SERVER['REMOTE_ADDR']);
        $data['text_info'] = sprintf($this->language->get('text_info'), $this->account->getCurrencyCode());

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_amount'] = sprintf($this->language->get('entry_amount'), $this->account->getCurrencyCode());
        $data['entry_description'] = $this->language->get('entry_description');

        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_send_money'] = $this->language->get('button_send_money');


        $data['back'] = $this->url->link('common/dashboard','token='.$this->session->data['token'],'SSL');

        $data['token'] = $this->session->data['token'];

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('fund/send.tpl', $data));
    }

} 