<?php
class Magext_MaxOrderAmount_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_ACTIVE = 'sales/magext_maxorderamount/active';
	const XML_PATH_SINGLE_ORDER_TOP_AMOUNT = 'sales/magext_maxorderamount/single_order_top_amount';
	const XML_PATH_SINGLE_ORDER_TOP_AMOUNT_MSG = 'sales/magext_maxorderamount/single_order_top_amount_msg';

	public function isModuleEnabled($moduleName = null)
	{
		if ((int)Mage::getStoreConfig(self::XML_PATH_ACTIVE, Mage::app()->getStore()) != 1) {
			return false;
		}
		return parent::isModuleEnabled($moduleName);
	}
	
	public function getSingleOrderTopAmount($store = null)
	{
		return (int)Mage::getStoreConfig(self::XML_PATH_SINGLE_ORDER_TOP_AMOUNT, $store);
	}
	
	public function getSingleOrderTopAmountMsg($store = null) 
	{
		return Mage::getStoreConfig(self::XML_PATH_SINGLE_ORDER_TOP_AMOUNT_MSG, $store);
	}
}