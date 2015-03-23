<?php

class Acez_AdminGrid_Block_Adminhtml_Color_Edit
	extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected function _construct()
	{
		$this->_blockGroup = 'acez_admingrid_adminhtml';
		$this->_controller = 'color';

		/*
		 * Koji folder magento koristi da bi pronasao related form blockove,
		 * koji su povezani sa ovim form container.
		 * AdminGrid/Block/Adminhtml/Color/Edit/
		 */
		$this->_mode = 'edit';

		$newOrEdit = $this->getRequest()->getParam('id')
			? $this->__('Edit')
			: $this->__('New');
		$this->_headerText = $newOrEdit . ' ' . $this->__('Color');
	}

	// moze da se doda i prepareLayout() tu editujemo dugmad (save, edit itd..) u edit strani
}
