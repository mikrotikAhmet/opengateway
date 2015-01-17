<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 10:03 PM
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

class ControllerFundCharge extends Controller {

	private $error = array();

	public function index(){

		$this->load->language('fund/charge');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/jquery/inputmask/js/jquery.mask.min.js');

		$this->getForm();

	}

	protected function getForm(){

		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_card_information'] = $this->language->get('text_card_information');
		$data['text_customer_information'] = $this->language->get('text_customer_information');
		$data['text_information'] = $this->language->get('text_information');

		$data['entry_amount'] = sprintf($this->language->get('entry_amount'),$this->account->getCurrencyCode());
		$data['entry_card_number'] = $this->language->get('entry_card_number');
		$data['entry_expire_date'] = $this->language->get('entry_expire_date');
		$data['entry_cvv'] = $this->language->get('entry_cvv');
		$data['entry_existing'] = $this->language->get('entry_existing');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['currentYear'] = date('Y');
		$data['currentMonth'] = date('m');
		$data['month_january'] = $this->language->get('month_january');
		$data['month_february'] = $this->language->get('month_february');
		$data['month_march'] = $this->language->get('month_march');
		$data['month_april'] = $this->language->get('month_april');
		$data['month_may'] = $this->language->get('month_may');
		$data['month_june'] = $this->language->get('month_june');
		$data['month_july'] = $this->language->get('month_july');
		$data['month_august'] = $this->language->get('month_august');
		$data['month_september'] = $this->language->get('month_september');
		$data['month_october'] = $this->language->get('month_october');
		$data['month_november'] = $this->language->get('month_november');
		$data['month_december'] = $this->language->get('month_december');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_charge'] = $this->language->get('button_charge');

		$data['cancel'] = $this->url->link('common/dashboard','token='.$this->session->data['token'],'SSL');

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('customer/customer');

		$data['customers'] = $this->model_customer_customer->getCustomers($this->account->getId());

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('fund/charge.tpl', $data));
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