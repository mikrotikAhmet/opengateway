<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');



		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
        $data['version'] = sprintf($this->language->get('text_version'), VERSION);

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

        $data['text_add_card'] = $this->language->get('text_add_card');
        $data['text_accepted_cards'] = $this->language->get('text_accepted_cards');
		$data['text_make_deposit'] = $this->language->get('text_make_deposit');
		$data['text_card_unverified'] = $this->language->get('text_card_unverified');
		$data['text_unverified_information'] = sprintf($this->language->get('text_unverified_information'),$this->currency->format($this->config->get('config_max_deposit'), $this->currency->getCode(), 1,true,false));

        $data['entry_card_number'] = $this->language->get('entry_card_number');
        $data['entry_expire_date'] = $this->language->get('entry_expire_date');
        $data['entry_cvv'] = $this->language->get('entry_cvv');
		$data['entry_amount'] = sprintf($this->language->get('entry_amount'),$this->account->getCurrencyCode());

        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_save_verify'] = $this->language->get('button_save_verify');
		$data['button_make_deposit'] = $this->language->get('button_make_deposit');

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

        return $this->load->view('common/footer.tpl', $data);
	}
}