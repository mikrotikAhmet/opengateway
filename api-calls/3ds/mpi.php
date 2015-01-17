<?php
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
 * Description of mpi.php
**/


$url = "http://api.semite.com/v3/gateway/doPayment";

$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>A28B5F6FD3</api_id>
		<secret_key>2E5191D6-A7D9-3C39-8C7C-DAD2FEBF67A3</secret_key>
	</authentication>
	<type>Charge</type>
	<securityCode>578</securityCode>
	<memberTrackingCode>CheckEnrollment 144059 15012015</memberTrackingCode>
	<paResult>X</paResult>
	<enrollmentId>102565</enrollmentId>
	<customer_ip_address>'.$_SERVER['REMOTE_ADDR'].'</customer_ip_address>
</request>';

$postfields = $post_string;
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);


$data = curl_exec($ch);

if(curl_errno($ch))
{
    print curl_error($ch);
}
else
{
    curl_close($ch);
    echo $data;
}