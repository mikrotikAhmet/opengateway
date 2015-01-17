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

class ControllerAccountAccount extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account');

		$this->getList();
	}

	public function add() {
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_account->addAccount($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_account_group_id'])) {
				$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_account->editAccount($this->request->get['account_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_account_group_id'])) {
				$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $account_id) {
				$this->model_account_account->deleteAccount($account_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_account_group_id'])) {
				$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function approve() {
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/account');

		$accounts = array();

		if (isset($this->request->post['selected'])) {
			$accounts = $this->request->post['selected'];
		} elseif (isset($this->request->get['account_id'])) {
			$accounts[] = $this->request->get['account_id'];
		}

		if ($accounts && $this->validateApprove()) {
			$this->model_account_account->approve($this->request->get['account_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_account_group_id'])) {
				$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	
	protected function getList(){


		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_account_group_id'])) {
			$filter_account_group_id = $this->request->get['filter_account_group_id'];
		} else {
			$filter_account_group_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_account_group_id'])) {
			$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'href' => $this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('account/account/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('account/account/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['accounts'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_account_group_id' => $filter_account_group_id,
			'filter_status'            => $filter_status,
			'filter_approved'          => $filter_approved,
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$account_total = $this->model_account_account->getTotalAccounts($filter_data);

		$results = $this->model_account_account->getAccounts($filter_data);

		foreach ($results as $result) {
			$data['accounts'][] = array(
				'account_id'    => $result['account_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'account_group' => $result['account_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'ip'             => $result['ip'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'           => $this->url->link('account/account/edit', 'token=' . $this->session->data['token'] . '&account_id=' . $result['account_id'] . $url, 'SSL'),
				'approve'        => $this->url->link('account/account/approve', 'token=' . $this->session->data['token'] . '&account_id=' . $result['account_id'] . $url, 'SSL'),
				'approved'       => $result['approved']
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_login'] = $this->language->get('text_login');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_account_group'] = $this->language->get('column_account_group');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_account_group'] = $this->language->get('entry_account_group');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_account_group_id'])) {
			$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_email'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$data['sort_account_group'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=account_group' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$data['sort_ip'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_account_group_id'])) {
			$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $account_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('account/account', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($account_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($account_total - $this->config->get('config_limit_admin'))) ? $account_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $account_total, ceil($account_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_account_group_id'] = $filter_account_group_id;
		$data['filter_status'] = $filter_status;
		$data['filter_approved'] = $filter_approved;
		$data['filter_ip'] = $filter_ip;
		$data['filter_date_added'] = $filter_date_added;

		$this->load->model('account/account_group');

		$data['account_groups'] = $this->model_account_account_group->getAccountGroups();

		$this->load->model('setting/application');

		$data['applications'] = $this->model_setting_application->getApplications();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/account_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['account_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		$data['text_api_access'] = $this->language->get('text_api_access');

		$data['warning_api_access'] = $this->language->get('warning_api_access');

		$data['entry_account_group'] = $this->language->get('entry_account_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');
		$data['entry_livemode'] = $this->language->get('entry_livemode');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_gmt_offset'] = $this->language->get('entry_gmt_offset');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_api_id'] = $this->language->get('entry_api_id');
		$data['entry_secret_key'] = $this->language->get('entry_secret_key');
        $data['entry_processor_id'] = $this->language->get('entry_processor_id');
        $data['entry_processor_guid'] = $this->language->get('entry_processor_guid');
        $data['entry_processor_id_amex'] = $this->language->get('entry_processor_id_amex');
        $data['entry_processor_guid_amex'] = $this->language->get('entry_processor_guid_amex');
		$data['entry_descriptor'] = $this->language->get('entry_descriptor');

		$data['help_live'] = $this->language->get('help_live');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_generate'] = $this->language->get('button_generate');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_address'] = $this->language->get('tab_address');
		$data['tab_login'] = $this->language->get('tab_login');
        $data['tab_processor'] = $this->language->get('tab_processor');
		$data['tab_api'] = $this->language->get('tab_api');
		$data['tab_ip'] = $this->language->get('tab_ip');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['account_id'])) {
			$data['account_id'] = $this->request->get['account_id'];
		} else {
			$data['account_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
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

		if (isset($this->error['country_id'])) {
			$data['error_country_id'] = $this->error['country_id'];
		} else {
			$data['error_country_id'] = '';
		}

		if (isset($this->error['currency'])) {
			$data['error_currency'] = $this->error['currency'];
		} else {
			$data['error_currency'] = '';
		}

		if (isset($this->error['language'])) {
			$data['error_language'] = $this->error['language'];
		} else {
			$data['error_language'] = '';
		}

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_account_group_id'])) {
			$url .= '&filter_account_group_id=' . $this->request->get['filter_account_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'href' => $this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['account_id'])) {
			$data['action'] = $this->url->link('account/account/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('account/account/edit', 'token=' . $this->session->data['token'] . '&account_id=' . $this->request->get['account_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['account_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$account_info = $this->model_account_account->getAccount($this->request->get['account_id']);
		}

		$this->load->model('account/account_group');

		$data['account_groups'] = $this->model_account_account_group->getAccountGroups();

		if (isset($this->request->post['account_group_id'])) {
			$data['account_group_id'] = $this->request->post['account_group_id'];
		} elseif (!empty($account_info)) {
			$data['account_group_id'] = $account_info['account_group_id'];
		} else {
			$data['account_group_id'] = $this->config->get('config_account_group_id');
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($account_info)) {
			$data['firstname'] = $account_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($account_info)) {
			$data['lastname'] = $account_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($account_info)) {
			$data['email'] = $account_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($account_info)) {
			$data['telephone'] = $account_info['telephone'];
		} else {
			$data['telephone'] = '';
		}


		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($account_info)) {
			$data['status'] = $account_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['livemode'])) {
			$data['livemode'] = $this->request->post['livemode'];
		} elseif (!empty($account_info)) {
			$data['livemode'] = $account_info['livemode'];
		} else {
			$data['livemode'] = 0;
		}

		if (isset($this->request->post['currency_code'])) {
			$data['currency_code'] = $this->request->post['currency_code'];
		} elseif (!empty($account_info)) {
			$data['currency_code'] = $account_info['currency_code'];
		} else {
			$data['currency_code'] = '';
		}

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		if (isset($this->request->post['language_code'])) {
			$data['language_code'] = $this->request->post['language_code'];
		} elseif (!empty($account_info)) {
			$data['language_code'] = $account_info['language_code'];
		} else {
			$data['language_code'] = '';
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($account_info)) {
			$data['address_1'] = $account_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($account_info)) {
			$data['address_2'] = $account_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($account_info)) {
			$data['city'] = $account_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($account_info)) {
			$data['postcode'] = $account_info['postal_code'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (!empty($account_info)) {
			$data['country_id'] = $account_info['country_id'];
		} else {
			$data['country_id'] = '';
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (!empty($account_info)) {
			$data['zone_id'] = $account_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		if (isset($this->request->post['gmt_offset'])) {
			$data['gmt_offset'] = $this->request->post['gmt_offset'];
		} elseif (!empty($account_info)) {
			$data['gmt_offset'] = $account_info['gmt_offset'];
		} else {
			$data['gmt_offset'] = '';
		}

		$this->load->helper('time_zone');

		$data['time_zones'] = getTimeZones();


		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($account_info)) {
			$data['username'] = $account_info['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

        if (isset($this->request->post['merchantID'])) {
            $data['processor_id'] = $this->request->post['merchantID'];
        } elseif (!empty($account_info)) {
            $data['processor_id'] = $account_info['merchantID'];
        } else {
            $data['processor_id'] = '';
        }

        if (isset($this->request->post['merchantGUID'])) {
            $data['processor_guid'] = $this->request->post['merchantGUID'];
        } elseif (!empty($account_info)) {
            $data['processor_guid'] = $account_info['merchantGUID'];
        } else {
            $data['processor_guid'] = '';
        }

        if (isset($this->request->post['merchantID_amex'])) {
            $data['processor_id_amex'] = $this->request->post['merchantID_amex'];
        } elseif (!empty($account_info)) {
            $data['processor_id_amex'] = $account_info['merchantID_amex'];
        } else {
            $data['processor_id_amex'] = '';
        }

        if (isset($this->request->post['merchantGUID_amex'])) {
            $data['processor_guid_amex'] = $this->request->post['merchantGUID_amex'];
        } elseif (!empty($account_info)) {
            $data['processor_guid_amex'] = $account_info['merchantGUID_amex'];
        } else {
            $data['processor_guid_amex'] = '';
        }


		if (isset($this->request->post['descriptor'])) {
			$data['descriptor'] = $this->request->post['descriptor'];
		} elseif (!empty($account_info)) {
			$data['descriptor'] = $account_info['dynamicDescriptor'];
		} else {
			$data['descriptor'] = '';
		}


		if (isset($this->request->post['api_id'])) {
			$data['api_id'] = $this->request->post['api_id'];
		} elseif (!empty($account_info)) {
			$data['api_id'] = $account_info['api_id'];
		} else {
			$data['api_id'] = '';
		}

		if (isset($this->request->post['secret_key'])) {
			$data['secret_key'] = $this->request->post['secret_key'];
		} elseif (!empty($account_info)) {
			$data['secret_key'] = $account_info['api_secret'];
		} else {
			$data['secret_key'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/account_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'account/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		$account_info = $this->model_account_account->getAccountByEmail($this->request->post['email']);

		if (!isset($this->request->get['account_id'])) {
			if ($account_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($account_info && ($this->request->get['account_id'] != $account_info['account_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 255)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (!$this->request->post['country_id']) {
			$this->error['country_id'] = $this->language->get('error_country_id');
		}

		if ((utf8_strlen($this->request->post['city']) < 3) || (utf8_strlen($this->request->post['city']) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		if ((utf8_strlen($this->request->post['username']) < 4) || (utf8_strlen(trim($this->request->post['lastname'])) > 16)) {
			$this->error['username'] = $this->language->get('error_username');
		}

		$account_info = $this->model_account_account->getAccountByUsername($this->request->post['username']);

		if (!isset($this->request->get['account_id'])) {
			if ($account_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($account_info && ($this->request->get['account_id'] != $account_info['account_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}



		if ($this->request->post['password'] || (!isset($this->request->get['account_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'account/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateApprove() {
		if (!$this->user->hasPermission('modify', 'account/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


	public function login() {
		$json = array();

		if (isset($this->request->get['account_id'])) {
			$account_id = $this->request->get['account_id'];
		} else {
			$account_id = 0;
		}

		$this->load->model('account/account');

		$account_info = $this->model_account_account->getAccount($account_id);

		if ($account_info) {
			$token = md5(mt_rand());

			$this->model_account_account->editToken($account_id, $token);

			if (isset($this->request->get['store_id'])) {
				$store_id = $this->request->get['store_id'];
			} else {
				$store_id = 0;
			}

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($store_id);

			if ($store_info) {
				$this->response->redirect($store_info['url'] . 'index.php?route=account/login&token=' . $token);
			} else {
				$this->response->redirect(HTTP_SERVER . 'index.php?route=account/login&token=' . $token);
			}
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
		}
	}

	public function transaction() {
		$this->load->language('account/account');

		$this->load->model('account/account');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'account/account')) {
			$this->model_account_account->addTransaction($this->request->get['account_id'], $this->request->post['description'], $this->request->post['amount']);

			$data['success'] = $this->language->get('text_success');
		} else {
			$data['success'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'account/account')) {
			$data['error_warning'] = $this->language->get('error_permission');
		} else {
			$data['error_warning'] = '';
		}

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_balance'] = $this->language->get('text_balance');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_amount'] = $this->language->get('column_amount');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['transactions'] = array();

		$results = $this->model_account_account->getTransactions($this->request->get['account_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$data['balance'] = $this->currency->format($this->model_account_account->getTransactionTotal($this->request->get['account_id']), $this->config->get('config_currency'));

		$transaction_total = $this->model_account_account->getTotalTransactions($this->request->get['account_id']);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/account/transaction', 'token=' . $this->session->data['token'] . '&account_id=' . $this->request->get['account_id'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));

		$this->response->setOutput($this->load->view('account/account_transaction.tpl', $data));
	}

	public function ip() {
		$this->load->language('account/account');

		$this->load->model('account/account');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['ips'] = array();

		$results = $this->model_account_account->getIps($this->request->get['account_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$ban_ip_total = $this->model_account_account->getTotalBanIpsByIp($result['ip']);

			$data['ips'][] = array(
				'ip'         => $result['ip'],
				'total'      => $this->model_account_account->getTotalAccountsByIp($result['ip']),
				'date_added' => date('d/m/y', strtotime($result['date_added'])),
				'filter_ip'  => $this->url->link('account/account', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'], 'SSL'),
				'ban_ip'     => $ban_ip_total
			);
		}

		$ip_total = $this->model_account_account->getTotalIps($this->request->get['account_id']);

		$pagination = new Pagination();
		$pagination->total = $ip_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/account/ip', 'token=' . $this->session->data['token'] . '&account_id=' . $this->request->get['account_id'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ip_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($ip_total - 10)) ? $ip_total : ((($page - 1) * 10) + 10), $ip_total, ceil($ip_total / 10));

		$this->response->setOutput($this->load->view('account/account_ip.tpl', $data));
	}

	public function addBanIp() {
		$this->load->language('account/account');

		$json = array();

		if (isset($this->request->post['ip'])) {
			if (!$this->user->hasPermission('modify', 'account/account')) {
				$json['error'] = $this->language->get('error_permission');
			} else {
				$this->load->model('account/account');

				$this->model_account_account->addBanIp($this->request->post['ip']);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeBanIp() {
		$this->load->language('account/account');

		$json = array();

		if (isset($this->request->post['ip'])) {
			if (!$this->user->hasPermission('modify', 'account/account')) {
				$json['error'] = $this->language->get('error_permission');
			} else {
				$this->load->model('account/account');

				$this->model_account_account->removeBanIp($this->request->post['ip']);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function generateKey() {

		sleep(1);

		$json = array();

		$v3id = strtoupper(UUID::random_key(10, $readable = true, $hash = true));
		$v3uuid = strtoupper(UUID::v3($this->config->get('config_encryption'), date('Ymd Hsi')));

		$json = array(
			'api_id'=>$v3id,
			'secret_key'=>$v3uuid
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}

			$this->load->model('account/account');

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_email' => $filter_email,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_account_account->getAccounts($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'account_id'       => $result['account_id'],
					'account_group_id' => $result['account_group_id'],
					'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'account_group'    => $result['account_group'],
					'firstname'         => $result['firstname'],
					'lastname'          => $result['lastname'],
					'email'             => $result['email'],
					'telephone'         => $result['telephone'],
					'fax'               => $result['fax'],
					'custom_field'      => unserialize($result['custom_field']),
					'address'           => $this->model_account_account->getAddresses($result['account_id'])
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