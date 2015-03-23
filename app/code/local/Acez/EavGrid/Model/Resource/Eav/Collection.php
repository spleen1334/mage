<?php

class Acez_EavGrid_Model_Resource_Eav_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init('acez_eavgrid/eav');
	}
}
