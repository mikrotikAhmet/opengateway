<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$operation = new Payvision_ThreeDSecureOperations_CheckEnrollment;
		$operation->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
		$operation->setCountryId(Payvision_Translator::getCountryIdFromIso('NLD'));

		$operation->setCardNumberAndHolder('4000000000000051');
		$operation->setCardExpiry('01', '2017');

		$operation->setAmountAndCurrencyId(1.2, Payvision_Translator::getCurrencyIdFromIsoCode('EUR'));

		$operation->setTrackingMemberCode('CheckEnrollment ' . date('His dmY'));

		if ($client->call($operation))
		{
			var_dump($operation->getResultState(),
				$operation->getResultCode(),
				$operation->getResultMessage(),
				$operation->getResultTrackingMemberCode(),
				$operation->getResultCdcName(),
				$operation->getResultEnrollmentId(),
				$operation->getResultIssuerUrl(),
				$operation->getResultPaymentAuthenticationRequest());

			echo $operation->getRedirectHtmlForm('https://www.google.com/');
		}
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}