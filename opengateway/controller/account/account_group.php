<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/10/15
 * Time: 12:56 PM
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

class ControllerAccountAccountGroup extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('account/account_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account_group');

		$this->getList();
	}

	public function add() {
		$this->load->language('account/account_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_account_group->addAccountGroup($this->request->post);

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

			$this->response->redirect($this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('account/account_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_account_group->editAccountGroup($this->request->get['account_group_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('account/account_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account_group');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $account_group_id) {
				$this->model_account_account_group->deleteAccountGroup($account_group_id);
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

			$this->response->redirect($this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cgd.name';
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
			'href' => $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('account/account_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('account/account_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['account_groups'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$account_group_total = $this->model_account_account_group->getTotalAccountGroups();

		$results = $this->model_account_account_group->getAccountGroups($filter_data);

		foreach ($results as $result) {
			$data['account_groups'][] = array(
				'account_group_id' => $result['account_group_id'],
				'name'              => $result['name'] . (($result['account_group_id'] == $this->config->get('config_account_group_id')) ? $this->language->get('text_default') : null),
				'sort_order'        => $result['sort_order'],
				'edit'              => $this->url->link('account/account_group/edit', 'token=' . $this->session->data['token'] . '&account_group_id=' . $result['account_group_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
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

		$data['sort_name'] = $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $account_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($account_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($account_group_total - $this->config->get('config_limit_admin'))) ? $account_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $account_group_total, ceil($account_group_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/account_group_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['account_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_personal'] = $this->language->get('entry_personal');
		$data['entry_business'] = $this->language->get('entry_business');
		$data['entry_business_contact'] = $this->language->get('entry_business_contact');
		$data['entry_approval'] = $this->language->get('entry_approval');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_approval'] = $this->language->get('help_approval');
		$data['help_personal'] = $this->language->get('help_personal');
		$data['help_business'] = $this->language->get('help_business');
		$data['help_business_contact'] = $this->language->get('help_business_contact');

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
			$data['error_name'] = array();
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
			'href' => $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['account_group_id'])) {
			$data['action'] = $this->url->link('account/account_group/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('account/account_group/edit', 'token=' . $this->session->data['token'] . '&account_group_id=' . $this->request->get['account_group_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('account/account_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['account_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$account_group_info = $this->model_account_account_group->getAccountGroup($this->request->get['account_group_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['account_group_description'])) {
			$data['account_group_description'] = $this->request->post['account_group_description'];
		} elseif (isset($this->request->get['account_group_id'])) {
			$data['account_group_description'] = $this->model_account_account_group->getAccountGroupDescriptions($this->request->get['account_group_id']);
		} else {
			$data['account_group_description'] = array();
		}

		if (isset($this->request->post['personal'])) {
			$data['personal'] = $this->request->post['personal'];
		} elseif (!empty($account_group_info)) {
			$data['personal'] = $account_group_info['personal'];
		} else {
			$data['personal'] = '';
		}

		if (isset($this->request->post['business'])) {
			$data['business'] = $this->request->post['business'];
		} elseif (!empty($account_group_info)) {
			$data['business'] = $account_group_info['business'];
		} else {
			$data['business'] = '';
		}

		if (isset($this->request->post['business_contact'])) {
			$data['business_contact'] = $this->request->post['business_contact'];
		} elseif (!empty($account_group_info)) {
			$data['business_contact'] = $account_group_info['business_contact'];
		} else {
			$data['business_contact'] = '';
		}

		if (isset($this->request->post['approval'])) {
			$data['approval'] = $this->request->post['approval'];
		} elseif (!empty($account_group_info)) {
			$data['approval'] = $account_group_info['approval'];
		} else {
			$data['approval'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($account_group_info)) {
			$data['sort_order'] = $account_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/account_group_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'account/account_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['account_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'account/account_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/application');
		$this->load->model('account/account');

		foreach ($this->request->post['selected'] as $account_group_id) {
			if ($this->config->get('config_account_group_id') == $account_group_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$application_total = $this->model_setting_application->getTotalApplicationsByAccountGroupId($account_group_id);

			if ($application_total) {
				$this->error['warning'] = sprintf($this->language->get('error_application'), $application_total);
			}

			$account_total = $this->model_account_account->getTotalAccountsByAccountGroupId($account_group_id);

			if ($account_total) {
				$this->error['warning'] = sprintf($this->language->get('error_account'), $account_total);
			}
		}

		return !$this->error;
	}
} 