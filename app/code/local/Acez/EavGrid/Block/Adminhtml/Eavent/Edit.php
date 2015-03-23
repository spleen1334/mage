<?php

class Acez_EavGrid_Block_Adminhtml_Eavent_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected function _construct()
	{
		$this->_blockGroup = 'acez_eavgrid_adminhtml';
		$this->_controller = 'eavent';

		$this->_mode = 'edit';

		$newOrEdit = $this->getRequest()->getParam('id')
			? $this->__('Edit')
			: $this->__('New');
		$this->_headerText = $newOrEdit . ' ' . $this->__('EAV ENTITY');
	}
}