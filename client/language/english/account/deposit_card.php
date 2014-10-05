<?php

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
 * @version     $Id: deposit_card.php Oct 5, 2014 ahmet
 */
/**
 * OGCA - Open Gateway Core Application
 * Description of deposit_card.php
 *
 * @author ahmet
 */
// Heading
$_['heading_title'] = 'Credit / Debit Card';

// Text
$_['text_amount_help'] = 'All deposits will be processed based of your account currency.';
$_['text_card_upload_step_2'] = 'Upload step 2: select your card and transfer the money';

// Entry
$_['entry_amount'] = 'Deposit Amount';

// Error
$_['error_no_card'] = '<h2>Warning!</h2>
                    <p>You do not have any cards registered and/or verified. To check your card statuses and/or verify your card <a href="%s">click here</a>.</p>';
$_['error_card'] = 'Please select your Credit / Debit Card to continue!';
$_['error_amount'] = 'Minimum deposit amount is %s';