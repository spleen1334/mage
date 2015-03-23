<?php

class Acez_ZeroCheckout_Model_Observer
{
	public function modifyPrice(Varien_Event_Observer $obs)
	{
		// Item iz carta
		$item = $obs->getQuoteItem();
		// Za configurable products
		$item = ( $item->getParentItem() ? $item->getParentItem() : $item );

		// Ucitaj odgovarajuci item
		$model = Mage::getSingleton('catalog/product')->load($item->getProductId());

		// getZeroPrice() getter za polje iz tabele
		if ( $model->getZeroPrice() ) {
			$price = 0;
			Mage::log('ZeroCheckout Radi!!!');

		} else {
			// za testiranje
//			$price = 33;
		}

		// Ovo je custom price on nije stalan
		$item->setCustomPrice( $price );
		$item->setOriginalCustomPrice( $price );
		// Neophodno (ima neki tutorial koji objasnjava zasto)
		$item->getProduct()->setIsSuperMode( true );
	}

}