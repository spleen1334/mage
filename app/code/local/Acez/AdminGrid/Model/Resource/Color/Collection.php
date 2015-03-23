<?php

class Acez_AdminGrid_Model_Resource_Color_Collection
	extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	protected function _construct()
	{
//		$this->_init('acez_admingrid/color', 'acez_admingrid/color');
		$this->_init('acez_admingrid/color'); // moze i bez drugog parametra jer su isti, ovo je uobicajeno
	}
}