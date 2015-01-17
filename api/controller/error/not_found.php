<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');


/**
 * theHive Gaming Platform
 *
 * @category   PhpStorm
 * @package    api_thehive.com
 * @copyright  Copyright 2009-2014 Egaming Cunsultant Ltd. Developments
 * @license    http://www.egamingc.net/license/
 * @version    not_found.php 10/22/14 ahmet $
 * @author     Ahmet GOUDENOGLU <agoudenoglu@egamingc.com>
 */

/**
 * @category   PhpStorm
 * @package    api_thehive.com
 * @copyright  Copyright 2009-2014 Egaming Cunsultant Ltd. Developments
 * @license    http://www.egamingc.net/license/
 */

class ControllerErrorNotFound extends Controller{

	public function index(){

		$this->_api->processApi('',404);

	}
}