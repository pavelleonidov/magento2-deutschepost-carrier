<?php
namespace PavelLeonidov\DeutschePostCarrier\Model\Carrier;

/*******************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Pavel Leonidov <pavel.leonidov@exconcept.com>, EXCONCEPT GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ******************************************************************/

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Config;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Psr\Log\LoggerInterface;

class DeutschePostCarrier extends AbstractCarrier implements CarrierInterface
{
	protected $_code = 'deutschepost';
	protected $_isFixed = true;
	protected $_rateResultFactory;
	protected $_rateMethodFactory;

	public function __construct(
		ScopeConfigInterface $scopeConfig,
		ErrorFactory $rateErrorFactory,
		LoggerInterface $logger,
		ResultFactory $rateResultFactory,
		MethodFactory $rateMethodFactory,
		array $data = []
	)

	{
		$this->_rateResultFactory = $rateResultFactory;
		$this->_rateMethodFactory = $rateMethodFactory;
		parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
	}

	public function getAllowedMethods()
	{
		return [$this->getCarrierCode() => __($this->getConfigData('name'))];
	}

	public function collectRates(RateRequest $request)
	{
		if (!$this->isActive())
		{
			return false;
		}

		$result = $this->_rateResultFactory->create();

		$shippingPrice = $this->getConfigData('price');

		$method = $this->_rateMethodFactory->create();

		$method->setCarrier($this->getCarrierCode());
		$method->setCarrierTitle($this->getConfigData('title'));

		$method->setMethod($this->getCarrierCode());
		$method->setMethodTitle($this->getConfigData('name'));

		$method->setPrice($shippingPrice);
		$method->setCost($shippingPrice);

		$result->append($method);
		return $result;
	}
}

?>