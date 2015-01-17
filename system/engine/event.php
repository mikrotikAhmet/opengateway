<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/2/15
 * Time: 3:41 PM
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

class Event {
	private $data = array();

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function register($key, $action) {
		$this->data[$key][] = $action;
	}

	public function unregister($key, $action) {
		unset($this->data[$key]);
	}

	public function trigger($key, &$arg = array()) {
		if (isset($this->data[$key])) {
			foreach ($this->data[$key] as $event) {
				$action = new Action($event, $arg);
				$action->execute($this->registry);
			}
		}
	}
}