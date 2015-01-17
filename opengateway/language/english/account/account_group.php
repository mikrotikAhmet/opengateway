<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/3/15
 * Time: 1:54 PM
 */
/**
 * @package     Semite LLC opengateway
 * @version     account_group.php 1/3/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of account_group.php
 *
 * @author root
 */

// Heading
$_['heading_title']     = 'Account Groups';

// Text
$_['text_success']      = 'Success: You have modified account groups!';
$_['text_list']         = 'Account Group List';
$_['text_add']          = 'Add Account Group';
$_['text_edit']         = 'Edit Account Group';

// Column
$_['column_name']       = 'Account Group Name';
$_['column_sort_order'] = 'Sort Order';
$_['column_action']     = 'Action';

// Entry
$_['entry_name']        = 'Account Group Name';
$_['entry_description'] = 'Description';
$_['entry_personal']    = 'Personal Details';
$_['entry_business']    = 'Business Details';
$_['entry_business_contact']    = 'Business Contact';
$_['entry_approval']    = 'Approve New Accounts';
$_['entry_sort_order']  = 'Sort Order';

// Help
$_['help_approval']     = 'Accounts must be approved by an administrator before they can login.';
$_['help_personal']     = 'Allow customers to enter their personal details';
$_['help_business']     = 'Allow customers to enter their business details';
$_['help_business_contact']     = 'Allow customers to enter their business contact';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify account groups!';
$_['error_name']         = 'Account Group Name must be between 3 and 32 characters!';
$_['error_default']      = 'Warning: This account group cannot be deleted as it is currently assigned as the default store account group!';
$_['error_application']        = 'Warning: This account group cannot be deleted as it is currently assigned to %s applications!';
$_['error_account']     = 'Warning: This account group cannot be deleted as it is currently assigned to %s accounts!';