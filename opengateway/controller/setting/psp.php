<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/26/14
 * Time: 4:19 PM
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

class ControllerSettingPsp extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('setting/psp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/psp');

		$this->getList();
	}

	public function add()
	{
		$this->load->language('setting/psp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/psp');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_psp->addPsp($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit()
	{
		$this->load->language('setting/psp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/psp');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_psp->editPsp($this->request->get['psp_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete()
	{
		$this->load->language('setting/psp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/psp');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $psp_id) {
				$this->model_setting_psp->deletePsp($psp_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList()
	{
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('setting/psp/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('setting/psp/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['psps'] = array();

		$filter_data = array(
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$psp_total = $this->model_setting_psp->getTotalPsps();

		$results = $this->model_setting_psp->getPsps($filter_data);

		foreach ($results as $result) {
			$data['psps'][] = array(
				'psp_id' => $result['psp_id'],
				'name' => $result['name'],
				'edit' => $this->url->link('setting/psp/edit', 'token=' . $this->session->data['token'] . '&psp_id=' . $result['psp_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_account'] = $this->language->get('column_account');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('setting/psp', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $psp_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($psp_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($psp_total - $this->config->get('config_limit_admin'))) ? $psp_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $psp_total, ceil($psp_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/psp_list.tpl', $data));
	}

	protected function getForm()
	{
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['psp_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_memberId'] = $this->language->get('entry_memberId');
		$data['entry_memberGuid'] = $this->language->get('entry_memberGuid');
		$data['entry_avs'] = $this->language->get('entry_avs');
		$data['entry_dynamicDescriptor'] = $this->language->get('entry_dynamicDescriptor');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_avs'] = $this->language->get('help_avs');
		$data['help_dynamicDescriptor'] = $this->language->get('help_dynamicDescriptor');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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

		if (isset($this->error['memberId'])) {
			$data['error_memberId'] = $this->error['memberId'];
		} else {
			$data['error_memberId'] = '';
		}

		if (isset($this->error['memberGuid'])) {
			$data['error_memberGuid'] = $this->error['memberGuid'];
		} else {
			$data['error_memberGuid'] = '';
		}


		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['psp_id'])) {
			$data['action'] = $this->url->link('setting/psp/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('setting/psp/edit', 'token=' . $this->session->data['token'] . '&psp_id=' . $this->request->get['psp_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('setting/psp', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['psp_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$psp_info = $this->model_setting_psp->getPsp($this->request->get['psp_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($psp_info)) {
			$data['name'] = $psp_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['memberId'])) {
			$data['memberId'] = $this->request->post['memberId'];
		} elseif (!empty($psp_info)) {
			$data['memberId'] = $psp_info['memberId'];
		} else {
			$data['memberId'] = '';
		}

		if (isset($this->request->post['memberGuid'])) {
			$data['memberGuid'] = $this->request->post['memberGuid'];
		} elseif (!empty($psp_info)) {
			$data['memberGuid'] = $psp_info['memberGuid'];
		} else {
			$data['memberGuid'] = '';
		}

		if (isset($this->request->post['avsAddress'])) {
			$data['avsAddress'] = $this->request->post['avsAddress'];
		} elseif (!empty($psp_info)) {
			$data['avsAddress'] = $psp_info['avsAddress'];
		} else {
			$data['avsAddress'] = 0;
		}

		if (isset($this->request->post['dynamicDescriptor'])) {
			$data['dynamicDescriptor'] = $this->request->post['dynamicDescriptor'];
		} elseif (!empty($psp_info)) {
			$data['dynamicDescriptor'] = $psp_info['dynamicDescriptor'];
		} else {
			$data['dynamicDescriptor'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($psp_info)) {
			$data['status'] = $psp_info['status'];
		} else {
			$data['status'] = 0;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/psp_form.tpl', $data));
	}

	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'setting/psp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['memberGuid']) < 2) || (utf8_strlen($this->request->post['memberGuid']) > 64)) {
			$this->error['memberGuid'] = $this->language->get('error_memberGuid');
		}

		if ((utf8_strlen($this->request->post['memberId']) < 2) || (utf8_strlen($this->request->post['memberId']) > 10)) {
			$this->error['memberId'] = $this->language->get('error_memberId');
		}

		return !$this->error;
	}

	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'setting/psp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete()
	{
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('setting/psp');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start' => 0,
				'limit' => 5
			);

			$results = $this->model_setting_psp->getPsps($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'psp_id' => $result['psp_id'],
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}