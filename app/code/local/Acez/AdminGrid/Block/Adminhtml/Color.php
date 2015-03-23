<?php

class Acez_Admingrid_Block_Adminhtml_Color
	extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected function _construct()
	{
		parent::_construct();

		/* 
		 * Podesava alias koji se koristi za pronalazenje blocka koji ce biti prikazan
		 * u okviru grid kontejnera
		 * AdminGrid/Block/Adminhtml */
		$this->_blockGroup = 'acez_admingrid_adminhtml';

		/* 
		 * Ovo oznacava folder koji sadrzi Grid.php i Edit.php
		 * AdminGrid/Block/Adminhtml/Color
		 */
		$this->_controller = 'color';


		// Naslov strane
		$this->_headerText = Mage::helper('acez_admingrid')->__('Color Selector');
	}

	public function getCreateUrl()
	{
		/*
		 * Kada se klikne na ADD button ovde se redirectuje
		 * ColorController >> editAction()
		 */
		return $this->getUrl(
			'acez_admingrid_admin/color/edit'
			);
	}
}