<?php

class Acez_EavGrid_Block_Adminhtml_Eavent extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected function _construct()
	{
		parent::_construct();

		$this->_blockGroup = 'acez_eavgrid_adminhtml';
		$this->_controller = 'eavent';

		$this->_headerText = Mage::helper('acez_eavgrid')->__('Eav Grid Lista');
	}

	public function getCreateUrl()
	{
		return $this->getUrl(
			'acez_eavgrid_admin/eav/edit'
		);
	}

}
