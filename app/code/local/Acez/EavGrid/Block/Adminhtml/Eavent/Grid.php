<?php

class Acez_EavGrid_Block_Adminhtml_Eavent_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('inchoo_blog/post')->getCollection()
			->addAttributeToSelect('title')
			->addAttributeToSelect('author');

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	public function getRowUrl( $row )
	{
		return $this->getUrl(
			'acez_eavgrid_admin/eav/edit',
			array(
				'id' => $row->getId()
			)
		);
	}

	protected function _prepareColumns()
	{
		$this->addColumn('entity_id', array(
			'header' => $this->_getHelper()->__('ID'),
			'type' => 'number',
			'index' => 'entity_id'
		));

		$this->addColumn('title', array(
			'header' => $this->_getHelper()->__('Title'),
			'index' => 'title'
		));

		$this->addColumn('author', array(
			'header' => $this->_getHelper()->__('Author'),
			'index' => 'author'
		));

		// Edit link
		$this->addColumn('action', array(
			'header' => $this->_getHelper()->__('Action'),
			'width' => '50px',
			'type' => 'action',
			'actions' => array(
				array(
					'caption' => $this->_getHelper()->__('Edit'),
					'url' => array(
						'base' => 'acez_eavgrid_admin/eav/edit',
					),
					'field' => 'id'
				),
			),
			'filter' => false,
			'sortable' => false,
			'index' => 'entity_id',
		));

		return parent::_prepareColumns();
	}

	// Pomocna metoda koja skracuje kucanje
	protected function _getHelper()
	{
		return Mage::helper('acez_eavgrid');
	}
}
