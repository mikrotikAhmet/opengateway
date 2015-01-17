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
 * semite.com
 * Description of customer.php Class
**/


class ControllerAccountCustomer extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('account/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

	public function add() {
		$this->load->language('account/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$url = "http://api.semite.com/v1/account/addCustomer";

			// XML Request

			$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>updateCustomer</request>
	<customer_id>'.$this->request->get['customer_id'].'</customer_id>
	<customer>'.json_encode($this->request->post).'</customer>
    <filter>
	</filter>
</request>';

			$postfields = $post_string;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


			$response = curl_exec($ch);

			if(curl_errno($ch))
			{
				print curl_error($ch);
			}
			else
			{
				curl_close($ch);
				print_r($response);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

    public function edit() {
        $this->load->language('account/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $url = "http://api.semite.com/v1/account/updateCustomer";

            // XML Request

            $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>updateCustomer</request>
	<customer_id>'.$this->request->get['customer_id'].'</customer_id>
	<customer>'.json_encode($this->request->post).'</customer>
    <filter>
	</filter>
</request>';

            $postfields = $post_string;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


            $response = curl_exec($ch);

            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            else
            {
                curl_close($ch);
                print_r($response);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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

            $this->response->redirect($this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    protected function getList() {

        $url = "http://api.semite.com/v1/account/getCustomers";

        // XML Request

        $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<request>getTransactions</request>
	<account_id>'.$this->account->getId().'</account_id>
    <filter>
	</filter>
</request>';

        $postfields = $post_string;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


        $response = curl_exec($ch);

        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        else
        {
            curl_close($ch);
            $customers = json_decode($response);
        }

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

        $data['add'] = $this->url->link('account/customer/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('account/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['customers'] = array();

        $filter_data = array(
            'filter_name'              => $filter_name,
            'filter_email'             => $filter_email,
            'filter_date_added'        => $filter_date_added,
            'sort'                     => $sort,
            'order'                    => $order,
            'start'                    => ($page - 1) * $this->config->get('config_item_limit'),
            'limit'                    => $this->config->get('config_item_limit')
        );

        $data['customers'] = array();

	    if (isset($customers->customers)) {
		    foreach ($customers->customers as $result) {

			    $data['customers'][] = array(
				    'customer_id' => $result->customer_id,
				    'name' => $result->name,
				    'email' => $result->email,
				    'date_added' => date($this->language->get('date_format_short'), strtotime($result->date_added)),
				    'edit' => $this->url->link('account/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $result->customer_id . $url, 'SSL')
			    );

		    }
	    }


        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_customer'] = $this->language->get('text_no_customer');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_email'] = $this->language->get('column_email');
        $data['column_date_added'] = $this->language->get('column_date_added');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_date_added'] = $this->language->get('entry_date_added');

        $data['button_add'] = $this->language->get('button_add');
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

        $data['sort_name'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_email'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
        $data['sort_date_added'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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
        $pagination->total = $customers->total_customers;;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($customers->total_customers) ? (($page - 1) * $this->config->get('config_item_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_item_limit')) > ($customers->total_customers - $this->config->get('config_item_limit'))) ? $customers->total_customers : ((($page - 1) * $this->config->get('config_item_limit')) + $this->config->get('config_item_limit')), $customers->total_customers, ceil($customers->total_customers / $this->config->get('config_item_limit')));

        $data['filter_name'] = $filter_name;
        $data['filter_email'] = $filter_email;
        $data['filter_date_added'] = $filter_date_added;


        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('account/customer_list.tpl', $data));
    }

    protected function getForm(){

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['customer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit').' <b class="text-muted pull-right">'.$this->request->get['customer_id'].'</b>';
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_customer_information'] = $this->language->get('text_customer_information');
        $data['text_information'] = $this->language->get('text_information');

        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_address_2'] = $this->language->get('entry_address_2');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_country'] = $this->language->get('entry_country');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->get['customer_id'])) {
            $data['customer_id'] = $this->request->get['customer_id'];
        } else {
            $data['customer_id'] = 0;
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

        if (isset($this->error['address'])) {
            $data['error_address'] = $this->error['address'];
        } else {
            $data['error_address'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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


        if (!isset($this->request->get['customer_id'])) {
            $data['action'] = $this->url->link('account/customer/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('account/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {

            $url = "http://api.semite.com/v1/account/getCustomer";

            $post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>'.$this->account->getApiId().'</api_id>
		<secret_key>'.$this->account->getApiSecret().'</secret_key>
	</authentication>
	<type>getCustomer</type>
	<customer_id>'.$this->request->get['customer_id'].'</customer_id>
</request>';

            $postfields = $post_string;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


            $response = curl_exec($ch);

            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            else
            {
                curl_close($ch);
                $customer = json_decode($response);

            }
            $customer_info = current($customer);
        }

        if (isset($this->request->post['customer']['firstname'])) {
            $data['firstname'] = $this->request->post['customer']['firstname'];
        } elseif (!empty($customer_info)) {
            $data['firstname'] = $customer_info->firstname;
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->request->post['customer']['lastname'])) {
            $data['lastname'] = $this->request->post['customer']['lastname'];
        } elseif (!empty($customer_info)) {
            $data['lastname'] = $customer_info->lastname;
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->request->post['customer']['email'])) {
            $data['email'] = $this->request->post['customer']['email'];
        } elseif (!empty($customer_info)) {
            $data['email'] = $customer_info->email;
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['customer']['telephone'])) {
            $data['telephone'] = $this->request->post['customer']['telephone'];
        } elseif (!empty($customer_info)) {
            $data['telephone'] = $customer_info->telephone;
        } else {
            $data['telephone'] = '';
        }

        if (isset($this->request->post['customer']['company'])) {
            $data['company'] = $this->request->post['customer']['company'];
        } elseif (!empty($customer_info)) {
            $data['company'] = $customer_info->company;
        } else {
            $data['company'] = '';
        }

        if (isset($this->request->post['customer']['address_1'])) {
            $data['address_1'] = $this->request->post['customer']['address_1'];
        } elseif (!empty($customer_info)) {
            $data['address_1'] = $customer_info->address_1;
        } else {
            $data['address_1'] = '';
        }

        if (isset($this->request->post['customer']['address_2'])) {
            $data['address_2'] = $this->request->post['customer']['address_2'];
        } elseif (!empty($customer_info)) {
            $data['address_2'] = $customer_info->address_2;
        } else {
            $data['address_2'] = '';
        }

        if (isset($this->request->post['customer']['country_id'])) {
            $data['country_id'] = $this->request->post['customer']['country_id'];
        } elseif (!empty($customer_info)) {
            $data['country_id'] = $customer_info->country_id;
        } else {
            $data['country_id'] = '';
        }


        $this->load->model('localisation/country');

        $data['countries'] = $this->model_localisation_country->getCountries();

        if (isset($this->request->post['customer']['zone_id'])) {
            $data['zone_id'] = $this->request->post['customer']['zone_id'];
        } elseif (!empty($customer_info)) {
            $data['zone_id'] = $customer_info->zone_id;
        } else {
            $data['zone_id'] = '';
        }

        if (isset($this->request->post['customer']['city'])) {
            $data['city'] = $this->request->post['customer']['city'];
        } elseif (!empty($customer_info)) {
            $data['city'] = $customer_info->city;
        } else {
            $data['city'] = '';
        }

        if (isset($this->request->post['customer']['postcode'])) {
            $data['postcode'] = $this->request->post['customer']['postcode'];
        } elseif (!empty($customer_info)) {
            $data['postcode'] = $customer_info->postcode;
        } else {
            $data['postcode'] = '';
        }


        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('account/customer_form.tpl', $data));
    }

	protected function validateForm(){

		if ((utf8_strlen($this->request->post['customer']['firstname']) < 3) || (utf8_strlen($this->request->post['customer']['firstname']) > 32)){
			$this->error['warning'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['customer']['lastname']) < 3) || (utf8_strlen($this->request->post['customer']['lastname']) > 32)){
			$this->error['warning'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['customer']['address_1']) < 3) || (utf8_strlen($this->request->post['customer']['address_1']) > 255)){
			$this->error['warning'] = $this->language->get('error_address_1');
		}

		if (!$this->request->post['customer']['country_id']){
			$this->error['warning'] = $this->language->get('error_country');
		}

		if ((utf8_strlen($this->request->post['customer']['city']) < 3) || (utf8_strlen($this->request->post['customer']['city']) > 255)){
			$this->error['warning'] = $this->language->get('error_city');
		}

		if ((utf8_strlen($this->request->post['customer']['telephone']) < 3)){
			$this->error['warning'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen($this->request->post['customer']['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['customer']['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->error;
		}

		return !$this->error;
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