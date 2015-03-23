<?php
class Acez_Shipment_Model_Shipping_Carrier_Fixy
  extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
  protected $_code = 'acez_shipment_fixy';

  public function collectRates(Mage_Shipping_Model_Rate_Request $request)
  {
    // Provera zemlje
    $countryId = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getData('country_id');

    if ($countryId == 'RS') {
      $price = 15;
    } elseif ($countryId == 'HU') {
      $price = 20;
    } else {
      $price = 30;
    }


    $result = Mage::getModel('shipping/rate_result');
    $method = Mage::getModel('shipping/rate_result_method');

    $method->setCarrier($this->_code);
    // $method->SetCarrierTitle($this->getConfigData('title')); // prijavljuje
    // error u logovima

    $method->setMethod($this->_code);
    $method->setMethodTitle($this->getConfigData('name'));

    $method->setPrice($price);
    $method->setCost($price);

    $result->append($method);

    return $result;
  }

  public function getAllowedMethods()
  {
    return array($this->_code => $this->getConfigData('name'));
  }
}
