<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/12/14
 * Time: 9:29 PM
 */

/**
 * Smatsa Question Bank
 *
 * @category   PhpStorm
 * @package    smatsa
 * @copyright  Copyright 2009-2014 Semite d.o.o. Developments
 * @license    http://www.semitepayment.com/license/
 * @version    home.php 10/22/14 ahmet $
 * @author     Ahmet GOUDENOGLU <ahmet.gudenoglu@semitepayment.com>
 */

/**
 * @category   PhpStorm
 * @package    smatsa
 * @copyright  Copyright 2009-2014 Semite d.o.o. Developments
 * @license    http://www.semitepayment.com/license/
 */

class Payvision_BasicOperations_Authorize extends Payvision_Operation
{
	protected $_action     = 'basicoperations';
	protected $_operation  = 'Authorize';
	protected $_parameters = array(
		'memberId'            => array(
			'required' => TRUE,
		),
		'memberGuid'          => array(
			'required' => TRUE,
		),
		'countryId'           => array(
			'required' => TRUE,
		),
		'amount'              => array(
			'required' => TRUE,
		),
		'currencyId'          => array(
			'required' => TRUE,
		),
		'trackingMemberCode'  => array(
			'required' => TRUE,
		),
		'cardNumber'          => array(
			'required' => TRUE,
		),
		'cardHolder'          => array(),
		'cardExpiryMonth'     => array(
			'required' => TRUE,
		),
		'cardExpiryYear'      => array(
			'required' => TRUE,
		),
		'cardCvv'             => array(),
		'cardType'            => array(),
		'issueNumber'         => array(),
		'merchantAccountType' => array(
			'required'      => TRUE,
			'default_value' => 1 // E-commerce
		),
		'dynamicDescriptor'   => array(),
		'avsAddress'          => array(),
		'avsZip'              => array(),
	);

	public function setAmountAndCurrencyId ($amount, $currency_id)
	{
		if (is_numeric($amount) && $amount > 0 && ctype_digit($currency_id))
		{
			$this->addData('amount',     $amount);
			$this->addData('currencyId', $currency_id);
		}
		else
		{
			throw new Payvision_Exception('Amount or Currency ID not set or invalid');
		}
	}

	public function setCardNumberAndHolder ($card_number, $card_holder = NULL)
	{
		$this->addData('cardNumber', $card_number);

		if ($card_holder)
			$this->addData('cardHolder', $card_holder);
	}

	public function setCardExpiry ($expiry_month, $expiry_year)
	{
		$this->addData('cardExpiryMonth', $expiry_month);
		$this->addData('cardExpiryYear',  $expiry_year);
	}

	public function setCardValidationCode ($card_vc)
	{
		$this->addData('cardCvv', $card_vc);
	}

	public function setCardType ($card_type)
	{
		$this->addData('cardType', $card_type);
	}

	public function setDynamicDescriptor ($descriptor)
	{
		$this->addData('dynamicDescriptor', $descriptor);
	}

	public function setAvsAddress ($avs_address, $avs_zip)
	{
		$this->addData('avsAddress', $avs_address);
		$this->addData('avsZip',     $avs_zip);
	}

    public function setMerchantType ($merchantType)
    {
        $this->addData('merchantAccountType', $merchantType);
    }
}