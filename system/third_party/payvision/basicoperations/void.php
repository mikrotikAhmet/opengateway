<?php
if (!defined('DIR_APPLICATION'))
	exit('No direct script access allowed');
	
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/12/14
 * Time: 10:00 PM
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

class Payvision_BasicOperations_Void extends Payvision_Operation
{
	protected $_action     = 'basicoperations';
	protected $_operation  = 'Void';
	protected $_parameters = array(
		'memberId'            => array(
			'required' => TRUE,
		),
		'memberGuid'          => array(
			'required' => TRUE,
		),
		'transactionId'       => array(
			'required' => TRUE,
		),
		'transactionGuid'       => array(
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
	);

	public function setTransactionIdAndGuid ($transaction_id, $transaction_guid)
	{
		if ($transaction_id && ctype_digit($transaction_id) && $transaction_guid)
		{
			$this->addData('transactionId', $transaction_id);
			$this->addData('transactionGuid', $transaction_guid);
		}
		else
		{
			throw new Payvision_Exception('Transaction ID or GUID not set or invalid');
		}
	}

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

    public function setMerchantType ($merchantType)
    {
        $this->addData('merchantAccountType', $merchantType);
    }
}