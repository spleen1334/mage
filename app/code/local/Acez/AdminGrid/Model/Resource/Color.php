<?php

class Acez_AdminGrid_Model_Resource_Color
	extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('acez_admingrid/color', 'entity_id');
	}
}