<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/26/14
 * Time: 4:25 PM
 */
/**
 * @package     Semite LLC opengateway
 * @version     psp.php 12/26/14 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of psp.php
 *
 * @author root
 */
// Heading
$_['heading_title']      = 'PSP - Payment Service Providers';

// Text
$_['text_success']       = 'Success: You have modified payment service providers!';
$_['text_list']          = 'Payment Service Provider List';
$_['text_add']           = 'Add Payment Service Provider';
$_['text_edit']          = 'Edit Payment Service Provider';

// Column
$_['column_name']        = 'Payment Service Provider Name';
$_['column_action']      = 'Action';

// Entry
$_['entry_name']         = 'PSP Name';
$_['entry_memberId']         = 'Member id';
$_['entry_memberGuid']         = 'Member guid';
$_['entry_avs']         = 'Avs address';
$_['entry_dynamicDescriptor']         = 'Dynamic Descriptor';
$_['entry_status']         = 'Status';

// Help
$_['help_avs'] = 'Enable or disable AVS (Address Verification System) for this gateway.';
$_['help_dynamicDescriptor'] = 'Enable or disable Dynamic Descriptor for this gateway.';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment service providers!';
$_['error_name']         = 'PSP Name must be between 2 and 64 characters!';
$_['error_memberId']         = 'Member Id must be between 2 and 10 characters!';
$_['error_memberGuid']         = 'Member GUID must be between 2 and 40 characters!';
