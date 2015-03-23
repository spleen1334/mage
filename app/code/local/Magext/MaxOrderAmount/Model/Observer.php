<?php
class Magext_MaxOrderAmount_Model_Observer
{
	public function enforceSingleOrderLimit($observer)
	{
		$helper = Mage::helper('magext_maxorderamount');
		if (!$helper->isModuleEnabled()) {
			return;
		}
		
		$quote = $observer->getEvent()->getQuote();
		
		if ((float)$quote->getGrandTotal() > (float)$helper->getSingleOrderTopAmount()) {
			$formatedPrice = Mage::helper('core')->currency($helper->getSingleOrderTopAmount(), true, false);
			
			Mage::getSingleton('checkout/session')->addError( $helper->__($helper->getSingleOrderTopAmountMsg(), $formatedPrice));
			
			Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'));
			Mage::app()->getResponse()->sendResponse();
			exit; // ???
		}
	}
}