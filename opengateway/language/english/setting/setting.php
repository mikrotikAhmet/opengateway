<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/3/15
 * Time: 8:47 AM
 */
/**
 * @package     Semite LLC opengateway
 * @version     setting.php 1/3/15 root
 * @copyright   Copyright (c) 2014 Semite LLC .
 * @license     http://www.semitepayment.com/license/
 */
/**
 * Description of setting.php
 *
 * @author root
 */
// Heading
$_['heading_title']                    = 'Settings';

// Text
$_['text_success']                     = 'Success: You have modified settings!';
$_['text_edit']                        = 'Edit Setting';
$_['text_mail']                        = 'Mail';
$_['text_smtp']                        = 'SMTP';
$_['text_account']                     = 'Account';
$_['text_gateway_pagination']                        = 'Gateway Pagination';
$_['text_channel']                        = 'Payment Channel(s) - PSP';
$_['text_mpi']                        = '3D-Secure & MPI';
$_['text_charge']                        = 'Payments & Charges';
$_['text_deposit']                        = 'Deposit Options';
$_['text_withdraw']                        = 'Withdraw Options';


// Entry
$_['entry_name']                       = 'Application Name';
$_['entry_owner']                      = 'Application Owner';
$_['entry_address']                    = 'Address';
$_['entry_geocode']                    = 'Geocode';
$_['entry_email']                      = 'E-Mail';
$_['entry_telephone']                  = 'Telephone';
$_['entry_fax']                        = 'Fax';
$_['entry_location']                   = 'Company Location';
$_['entry_meta_title']                 = 'Meta Title';
$_['entry_meta_description']           = 'Meta Tag Description';
$_['entry_meta_keyword']               = 'Meta Tag Keywords';
$_['entry_layout']                     = 'Default Layout';
$_['entry_template']                   = 'Template';
$_['entry_country']                    = 'Country';
$_['entry_zone']                       = 'Region / State';
$_['entry_language']                   = 'Language';
$_['entry_admin_language']             = 'Administration Language';
$_['entry_currency']                   = 'Currency';
$_['entry_currency_auto']              = 'Auto Update Currency';
$_['entry_item_limit']              = 'Default Items Per Page (Gateway)';
$_['entry_limit_admin']                = 'Default Items Per Page (Admin)';
$_['entry_account_online']            = 'Accounts Online';
$_['entry_account_group']             = 'Account Group';
$_['entry_account_group_display']     = 'Account Groups';
$_['entry_account_mail']               = 'New Account Alert Mail';
$_['entry_channel']                   = 'PSP Channel';
$_['entry_amex_channel']                   = 'PSP AMEX Channel';
$_['entry_mpi']                   = 'Use MPI';
$_['entry_min_transfer']                   = 'Minimal transfer';
$_['entry_max_transfer']                   = 'Maximal transfer';
$_['entry_transfer_fee']                   = 'Transfer fee';
$_['entry_transfer_percent']                   = 'Transfer percentage';
$_['entry_refund_period']                   = 'Refund period, days';
$_['entry_min_deposit']                   = 'Minimal deposit';
$_['entry_max_deposit']                   = 'Maximal deposit';
$_['entry_min_withdraw']                   = 'Minimal withdraw';
$_['entry_max_withdraw']                   = 'Maximal withdraw';
$_['entry_logo']                       = 'Application Logo';
$_['entry_icon']                       = 'Icon';
$_['entry_ftp_hostname']               = 'FTP Host';
$_['entry_ftp_port']                   = 'FTP Port';
$_['entry_ftp_username']               = 'FTP Username';
$_['entry_ftp_password']               = 'FTP Password';
$_['entry_ftp_root']                   = 'FTP Root';
$_['entry_ftp_status']                 = 'Enable FTP';
$_['entry_mail_alert']                 = 'Additional Alert E-Mails';
$_['entry_mail_protocol']              = 'Mail Protocol';
$_['entry_mail_parameter']             = 'Mail Parameters';
$_['entry_smtp_hostname']              = 'SMTP Hostname';
$_['entry_smtp_username']              = 'SMTP Username';
$_['entry_smtp_password']              = 'SMTP Password';
$_['entry_smtp_port']                  = 'SMTP Port';
$_['entry_smtp_timeout']               = 'SMTP Timeout';
$_['entry_fraud_detection']            = 'Use MaxMind Fraud Detection System';
$_['entry_fraud_key']                  = 'MaxMind License Key';
$_['entry_fraud_score']                = 'MaxMind Risk Score';
$_['entry_fraud_status']               = 'MaxMind Fraud Order Status';
$_['entry_secure']                     = 'Use SSL';
$_['entry_shared']                     = 'Use Shared Sessions';
$_['entry_robots']                     = 'Robots';
$_['entry_seo_url']                    = 'Use SEO URLs';
$_['entry_file_max_size']	           = 'Max File Size';
$_['entry_file_ext_allowed']           = 'Allowed File Extensions';
$_['entry_file_mime_allowed']          = 'Allowed File Mime Types';
$_['entry_maintenance']                = 'Maintenance Mode';
$_['entry_password']                   = 'Allow Forgotten Password';
$_['entry_encryption']                 = 'Encryption Key';
$_['entry_compression']                = 'Output Compression Level';
$_['entry_error_display']              = 'Display Errors';
$_['entry_error_log']                  = 'Log Errors';
$_['entry_error_filename']             = 'Error Log Filename';
$_['entry_google_analytics']           = 'Google Analytics Code';

// Help
$_['help_geocode']                     = 'Please enter your company location geocode manually.';
$_['help_location']                    = 'The different company locations you have that you want displayed on the contact us form.';
$_['help_currency']                    = 'Change the default currency. Clear your browser cache to see the change and reset your existing cookie.';
$_['help_currency_auto']               = 'Set your company to automatically update currencies daily.';
$_['help_item_limit'] 	           = 'Determines how many gateway items are shown per page (transactions, accounts, etc).';
$_['help_limit_admin']   	           = 'Determines how many admin items are shown per page (transactions, accounts, etc).';
$_['help_account_online']             = 'Track accounts online via the account reports section.';
$_['help_account_group']              = 'Default account group.';
$_['help_account_group_display']      = 'Display account groups that new accounts can select to use such as wholesale and business when signing up.';
$_['help_account_mail']                = 'Send an email to the application owner when a new account is registered.';
$_['help_channel']                    = 'Change the default channel. This channel will be used to process Visa, Mastercard, JCB and others.';
$_['help_amex_channel']                    = 'Change the default AMEX channel. This channel will be used to process AMEX (American Express) cards only.';
$_['help_mpi']                    = 'Change the default channel MPI. This option will enable Merchant Plug-In (MPI) for 3D-Secure operations.';
$_['help_min_transfer'] ='Minimal transfer amount (e.g. 5.00).';
$_['help_max_transfer'] ='Maximal transfer amount (e.g. 100.00).(FOR UNVERIFIED MEMBERS ONLY)';
$_['help_transfer_fee'] ='Fee to charge individuals when they receive money.';
$_['help_transfer_percent'] ='Percentage to charge individuals when they receive money.';
$_['help_refund_period'] ='Period when member can use refund function.';
$_['help_min_deposit'] ='Minimal amount that a member can deposit into account.';
$_['help_max_deposit'] ='Maximal amount that a member can deposit into account (e.g. 100.00).(FOR UNVERIFIED MEMBERS ONLY)';
$_['help_min_withdraw'] ='Minimal amount that a member can withdraw from account.';
$_['help_max_withdraw'] ='Maximal amount that a member can withdraw from account (e.g. 100.00).(FOR UNVERIFIED MEMBERS ONLY)';
$_['help_icon']                        = 'The icon should be a PNG that is 16px x 16px.';
$_['help_ftp_root']                    = 'The directory your OpenCart installation is applicationd in. Normally \'public_html/\'.';
$_['help_mail_protocol']               = 'Only choose \'Mail\' unless your host has disabled the php mail function.';
$_['help_mail_parameter']              = 'When using \'Mail\', additional mail parameters can be added here (e.g. -f email@applicationaddress.com).';
$_['help_mail_smtp_hostname']          = 'Add \'tls://\' prefix if security connection is required. (e.g. tls://smtp.gmail.com).';
$_['help_mail_alert']                  = 'Any additional emails you want to receive the alert email, in addition to the main application email. (comma separated).';
$_['help_fraud_detection']             = 'MaxMind is a fraud detection service. If you don\'t have a license key you can <a href="http://www.maxmind.com/?rId=opencart" target="_blank"><u>sign up here</u></a>. Once you have obtained a key, copy and paste it into the field below.';
$_['help_fraud_score']                 = 'The higher the score the more likely the order is fraudulent. Set a score between 0 - 100.';
$_['help_fraud_status']                = 'Orders over your set score will be assigned this order status and will not be allowed to reach the complete status automatically.';
$_['help_secure']                      = 'To use SSL check with your host if a SSL certificate is installed and add the SSL URL to the catalog and admin config files.';
$_['help_shared']                      = 'Try to share the session cookie between applications so the cart can be passed between different domains.';
$_['help_robots']                      = 'A list of web crawler user agents that shared sessions will not be used with. Use separate lines for each user agent.';
$_['help_seo_url']                     = 'To use SEO URLs, apache module mod-rewrite must be installed and you need to rename the htaccess.txt to .htaccess.';
$_['help_file_max_size']		       = 'The maximum image file size you can upload in Image Manager. Enter as byte.';
$_['help_file_ext_allowed']            = 'Add which file extensions are allowed to be uploaded. Use a new line for each value.';
$_['help_file_mime_allowed']           = 'Add which file mime types are allowed to be uploaded. Use a new line for each value.';
$_['help_maintenance']                 = 'Prevents accounts from browsing your application. They will instead see a maintenance message. If logged in as admin, you will see the application as normal.';
$_['help_password']                    = 'Allow forgotten password to be used for the admin. This will be disabled automatically if the system detects a hack attempt.';
$_['help_encryption']                  = 'Please provide a secret key that will be used to encrypt private information when processing orders.';
$_['help_compression']                 = 'GZIP for more efficient transfer to requesting clients. Compression level must be between 0 - 9.';
$_['help_google_analytics']            = 'Login to your <a href="http://www.google.com/analytics/" target="_blank"><u>Google Analytics</u></a> account and after creating your website profile copy and paste the analytics code into this field.';

// Error
$_['error_warning']                    = 'Warning: Please check the form carefully for errors!';
$_['error_permission']                 = 'Warning: You do not have permission to modify settings!';
$_['error_name']                       = 'Application Name must be between 3 and 32 characters!';
$_['error_owner']                      = 'Application Owner must be between 3 and 64 characters!';
$_['error_address']                    = 'Application Address must be between 10 and 256 characters!';
$_['error_email']                      = 'E-Mail Address does not appear to be valid!';
$_['error_telephone']                  = 'Telephone must be between 3 and 32 characters!';
$_['error_meta_title']                 = 'Title must be between 3 and 32 characters!';
$_['error_limit']       	           = 'Limit required!';
$_['error_account_group_display']     = 'You must include the default account group if you are going to use this feature!';
$_['error_ftp_hostname']               = 'FTP Host required!';
$_['error_ftp_port']                   = 'FTP Port required!';
$_['error_ftp_username']               = 'FTP Username required!';
$_['error_ftp_password']               = 'FTP Password required!';
$_['error_error_filename']             = 'Error Log Filename required!';
$_['error_encryption']                 = 'Encryption Key must be between 3 and 32 characters!';
$_['error_min_transfer']                       = 'Please specify minimal transfer amount';
$_['error_max_transfer']                       = 'Please specify maximal transfer amount';
$_['error_transfer_fee']                       = 'Please specify per transfer fee';
$_['error_transfer_percent']                       = 'Please specify per transfer percentage';
$_['error_refund_period']                       = 'Set refund function activation period';
$_['error_min_deposit']                       = 'Please specify minimal deposit amount';
$_['error_max_deposit']                       = 'Please specify maximal deposit amount';
$_['error_min_withdraw']                       = 'Please specify minimal withdraw amount';
$_['error_max_withdraw']                       = 'Please specify maximal withdraw amount';
