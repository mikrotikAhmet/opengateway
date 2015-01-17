<?php

$url = "http://api.semite.com/v1/gateway/Charge";

$amount = 15.00;


$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>A28B5F6FD3</api_id>
		<secret_key>2E5191D6-A7D9-3C39-8C7C-DAD2FEBF67A3</secret_key>
	</authentication>
	<request>Payment</request>
	<credit_card>
	    <card_holder>Mike Dough</card_holder>
		<card_num>4012000033330026</card_num>
		<exp_month>12</exp_month>
		<exp_year>2016</exp_year>
		<cvv>999</cvv>
	</credit_card>
	<customer_ip_address>92.244.132.8</customer_ip_address>
	<merchantType>1</merchantType>
	<additionalInfo>
	<description>Test test from ecommerce</description>
	</additionalInfo>
	<amount>'.$amount.'</amount>

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
//    echo $data;
	echo '<pre>';
	print_r(json_decode($data));
}


?>