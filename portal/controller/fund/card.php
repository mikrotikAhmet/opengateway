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
 * Description of card.php Class
**/


class ControllerFundCard extends Controller {

    private $error = array();

    public function index(){

        $this->load->language('fund/card');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['text_upload_step_2'] = $this->language->get('text_upload_step_2');
	    $data['text_fingerprint'] = $this->language->get('text_fingerprint');
	    $data['text_status'] = $this->language->get('text_status');

        $data['button_back'] = $this->language->get('button_back');
        $data['button_continue'] = $this->language->get('button_continue');

        $data['back'] = $this->url->link('fund/upload','token='.$this->session->data['token'],'SSL');

        $data['token'] = $this->session->data['token'];

        $this->load->model('gateway/card');

	    $data['cards'] = array();

        $cards = $this->model_gateway_card->getCards();

	    foreach ($cards as $card){
		    $data['cards'][] = array(
			    'card_id'=>$card['card_id'],
			    'card_num'=>$card['card_num'],
			    'fingerprint'=>$card['fingerprint'],
			    'type'=>$card['type'],
			    'verified'=>$card['verified'],
                'token'=>$card['token'],
			    'text_verified'=>($card['verified'] ? $this->language->get('text_verified') : $this->language->get('text_unverified')),
		    );
	    }

        if (!$data['cards']){
            $this->response->redirect($this->url->link('fund/upload','token='.$this->session->data['token'],'SSL'));
        }

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('fund/card.tpl', $data));
    }
} 