<?php

$url = "http://api.semite.com/v3/gateway/Charge";

$amount = 135.00;


$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<request>
	<authentication>
		<api_id>A28B5F6FD3</api_id>
		<secret_key>2E5191D6-A7D9-3C39-8C7C-DAD2FEBF67A3</secret_key>
	</authentication>
	<request>Charge</request>
	<credit_card>
	    <card_holder>Claire Sullivan</card_holder>
		<card_num>5200000000000056</card_num>
		<exp_month>01</exp_month>
		<exp_year>2018</exp_year>
		<cvv>578</cvv>
	</credit_card>
	<customer_id></customer_id>
	<customer>
	    <firstname>Nejla</firstname>
	    <lastname>Goudenoglu</lastname>
	    <company></company>
	    <email>nejla@test.com</email>
	    <country_id>55</country_id>
	    <address_1>Test address 2</address_1>
	    <address_2></address_2>
	    <city>Test city</city>
	    <zone_id></zone_id>
	    <postal_code></postal_code>
	    <telephone>+123456789987</telephone>
	</customer>
	<customer_ip_address>92.244.132.8</customer_ip_address>
	<merchantType>1</merchantType>
	<amount>'.$amount.'</amount>
	<description>Test payment charge via eCommerce site for product #3354</description>
	<dynamicDescriptor>Company LLC|City|+123456789874</dynamicDescriptor>
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
    print_r($_POST);
    echo $data;
}


?>