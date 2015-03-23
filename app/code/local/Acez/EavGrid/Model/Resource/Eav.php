<?php

class Acez_EavGrid_Model_Resource_Eav extends Mage_Eav_Model_Entity_Abstract
{
	public function _construct()
	{
		$resource = Mage::getSingleton('core/resource');
		$this->setType('acez_eavgrid_entity');
		$this->setConnection(
			$resource->getConnection('eavgrid_read'),
			$resource->getConnection('eavgrid_write')
		);
	}
}
