<?php
class Magext_Cargo_Model_Shipping_Carrier_Fixy 
        extends Mage_Shipping_Model_Carrier_Abstract
        implements Mage_Shipping_Model_Carrier_Interface
{
	protected $_code = 'magext_cargo_fixy';
	
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		// Zabrani u admin, only available in frontend (sales/orders/create new order zabranjeno)
		if (!$this->getConfigFlag('active') || Mage::app()->getStore()->isAdmin()) {
			return false;
        }

		// Odredjivanje Shipping price
		$shippingPrice = 20;
		$grandTotal = Mage::getModel('checkout/session')->getQuote()->getGrandTotal();
		
		// Za kupovine preko $100 veci popust za shiping
		if ($grandTotal > 100) {
			$shippingPrice = 10;
		}

		$result = Mage::getModel('shipping/rate_result');
		$method = Mage::getModel('shipping/rate_result_method');
		
		$method->setCarrier($this->_code);
		$method->setCarrierTitle($this->getConfigData('title'));
		
		$method->setMethod($this->_code);
		$method->setMethodTitle($this->getConfigData('name'));
		
		$method->setPrice($shippingPrice);
		$method->setCost($shippingPrice);
		
		$result->append($method);
		
		return $result;
	}
	
	public function getAllowedMethods()
	{
		return array( $this->_code => $this->getConfigData('name'));
	}
}
        	