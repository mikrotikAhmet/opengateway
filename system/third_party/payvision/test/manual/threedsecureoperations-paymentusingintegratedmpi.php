<?php
	require(__DIR__ . '/../payvision_autoload.php');

	try
	{
		$client = new Payvision_Client(Payvision_Client::ENV_TEST);

		$payment = new Payvision_ThreeDSecureOperations_PaymentUsingIntegratedMPI;
		$payment->setMember('1002785', 'A8693AA8-EEB0-43B1-8043-FF1602093C23');
		$payment->setCountryId(Payvision_Translator::getCountryIdFromIso('CYP'));

		$payment->setTrackingMemberCode('PaymentUsingIntegratedMPI ' . date('His dmY'));

		$payment->setCardValidationCode('237');

		// ID returned in the Enrollment check: $operation->getResultEnrollmentId()
		$payment->setEnrollmentId('101153');

		// Tracking Member Code used in the Enrollment check
		$payment->setEnrollmentTrackingMemberCode('CheckEnrollment 105847 14012015');

		// Provided in redirection after 3D secure check: $_POST['PaRes']
		$payment->setPayerAuthenticationResponse('eNpVUtluwjAQfPdXINTn2A6mHFos0VJUKCkhhKN9i4xFQpsDJyHQr28cSI+3nd31eGZscH0l5WgpRa4kB0umqbeXjWA3aFJl0+1IsYU1ms4F27fnDmlysIeOPHI4SZUGccSpQQwTcA1RSaGE70UZB08cHyavnDHWarUA3yCCUKrJiFOzxdr3nW4P8LWBIPJCyV2ZZo2aBHDVQyDiPMrUhXcZAVwDBLn65H6WJX2Mi6IwEu9yCrQOQ8QhYD1FgH8V2bmu0tLoOdhxaztdWGv/SRwcx105L65pkfevtb06DAeA9QaCnZdJbhLaJpSyBqV9QvuUAq76CLxQS+F3JjFIKewGEST6ouEVmUSP/nZKO7lSMhK1nxohkOckjqQ+BfinLj38Kn981smKrExMiA+xO40Xy3F3WbyJ2bi3WW2O61knFTruaqeiDMqwaIfQijOoksOaB98eE9/evaz+/YdvYACv1A==');

		$client->call($payment);

        echo '<pre>';
        print_r($payment);
	}
	catch (Payvision_Exception $e)
	{
		echo $e->getMessage();
	}