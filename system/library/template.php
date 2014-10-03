<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC. Dev Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC.
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @version		Version 1.0.1
 */
// ------------------------------------------------------------------------

/**
 * OGCA - Open Gateway Core Application
 * Description of template.php Class
**/


class Template {
    public $data = array();

    public function fetch($filename) {
        $file = DIR_TEMPLATE . $filename;

        if (file_exists($file)) {
            extract($this->data);

            ob_start();

            include($file);

            $content = ob_get_clean();

            return $content;
        } else {
            trigger_error('Error: Could not load template ' . $file . '!');
            exit();
        }
    }
}