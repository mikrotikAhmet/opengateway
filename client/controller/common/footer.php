<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 * OGCA
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC..
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * @package     Semite LLC
 * @version     $Id: footer.php Oct 4, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of footer  Class
 *
 * @author ahmet
 */
/*
 * Copyright (C) 2014 ahmet
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ControllerCommonFooter extends Controller {

    protected function index() {
        $this->language->load('common/footer');
        
        $this->data['button_back'] = $this->language->get('button_back');
        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['text_footer'] = sprintf($this->language->get('text_footer'), _ENGINE_VER);
        
        $this->data['currentYear'] = date('Y');
        $this->data['currentMonth'] = date('m');
        
        $this->data['month_january'] = $this->language->get('month_january');
        $this->data['month_february'] = $this->language->get('month_february');
        $this->data['month_march'] = $this->language->get('month_march');
        $this->data['month_april'] = $this->language->get('month_april');
        $this->data['month_may'] = $this->language->get('month_may');
        $this->data['month_june'] = $this->language->get('month_june');
        $this->data['month_july'] = $this->language->get('month_july');
        $this->data['month_august'] = $this->language->get('month_august');
        $this->data['month_september'] = $this->language->get('month_september');
        $this->data['month_october'] = $this->language->get('month_october');
        $this->data['month_november'] = $this->language->get('month_november');
        $this->data['month_december'] = $this->language->get('month_december');

        if (file_exists(DIR_SYSTEM . 'config/svn/svn.ver')) {
            $this->data['text_footer'] .= '.r' . trim(file_get_contents(DIR_SYSTEM . 'config/svn/svn.ver'));
        }

        $this->template = 'common/footer.tpl';

        $this->render();
    }

}

