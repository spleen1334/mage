<?php

class Acez_AdminGrid_Model_Color
	extends Mage_Core_Model_Abstract
{
	const COLOR_METALIC = '0';
	const COLOR_PEARL = '1';
	const COLOR_MATTE = '2';

	protected function _construct() 
	{
		$this->_init('acez_admingrid/color');
	}

	// Niz za opcije u select
	public function getColorTypes()
	{
		return array(
			self::COLOR_METALIC
				=> Mage::helper('acez_admingrid')->__('Metalic color finish.'),
			self::COLOR_PEARL
				=> Mage::helper('acez_admingrid')->__('Pearl color finish.'),
			self::COLOR_MATTE
				=> Mage::helper('acez_admingrid')->__('Matte color finish.'),
		);
	}

}