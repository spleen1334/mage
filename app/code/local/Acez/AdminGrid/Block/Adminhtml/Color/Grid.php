<?php

class Acez_AdminGrid_Block_Adminhtml_Color_Grid
	extends Mage_Adminhtml_Block_Widget_Grid
{
	protected function _prepareCollection()
	{
		// Koja kolekcija se koristi u gridu
		$collection = Mage::getResourceModel(
			'acez_admingrid/color_collection'
			);
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}
	
	public function getRowUrl( $row )
	{
		/*
		 * Kada se klikne na grid, ovde se vrsi redirect
		 * editAction
		 */
		return $this->getUrl( 'acez_admingrid_admin/color/edit',
			array( 
				'id' => $row->getId()
			)
		);
	}

	protected function _prepareColumns() { // Columns u gridu
		$this->addColumn('entity_id', array(
			'header' => $this->_getHelper()->__('ID'), // naziv
			'type'   => 'number', // tip podatka
			'index'  => 'entity_id', // db table naziv
		));


		$this->addColumn('name', array(
			'header' => $this->_getHelper()->__('Name'),
			'type'   => 'text',
			'index'  => 'name',
		));

		$this->addColumn('description', array(
			'header' => $this->_getHelper()->__('Description'),
			'type'   => 'text',
			'index'  => 'description',
		));


		// Ovde ucitavamo odgovarajuci model da bi mogli da omogucimo i 'options'
		$colorSingleton = Mage::getSingleton( 'acez_admingrid/color');
		$this->addColumn('color_type', array(
			'header' => $this->_getHelper()->__('Color type'),
			'type'   => 'options',
			'index'  => 'color_type',
			'width'  => '200px',
			'options'=> $colorSingleton->getColorTypes()
		));

		// Ovo kreira edit dugme
		$this->addColumn('action', array(
			'header'  => $this->_getHelper()->__('Action'),
			'width'   => '50px',
			'type'    => 'action',
			'actions' => array(
				array(
					'caption'  => $this->_getHelper()->__('Edit'),
					'url' 	   => array(
									// nije objasnjeno zasto ide string concat
								   'base' => 'acez_admingrid_admin' . '/color/edit',
								),
					'field'    => 'id'
				),
			),
			'filter' => false,
			'sortable' => false,
			'index'  => 'entity_id',
		));


		return parent::_prepareColumns();
	}


	// Shortcut method, da smanji kucanje
	protected function _getHelper()
	{
		return Mage::helper('acez_admingrid');
	}
}
