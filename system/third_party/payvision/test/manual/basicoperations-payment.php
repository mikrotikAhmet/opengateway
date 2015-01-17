<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$operation = new Payvision_BasicOperations_Authorize();
		$operation->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
		$operation->setCountryId(Payvision_Translator::getCountryIdFromIso('SRB'));

		$operation->setCardNumberAndHolder('4775889400000171');
		$operation->setCardExpiry('12', '2016');
		$operation->setCardValidationCode('313');

		$operation->setAmountAndCurrencyId(5, Payvision_Translator::getCurrencyIdFromIsoCode('USD'));

		$operation->setTrackingMemberCode('Authorize ' . date('His dmY'));

		$client->call($operation);

		var_dump(
			$operation->getResultState(),
			$operation->getResultCode(),
			$operation->getResultMessage(),
			$operation->getResultTransactionId(),
			$operation->getResultTransactionGuid(),
			$operation->getResultTransactionDateTime(),
			$operation->getResultTrackingMemberCode(),
			$operation->getResultCdcData()
		);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}