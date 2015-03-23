<?php

class Acez_SalesDelete_Model_Observer
{
	// varien_event_observer ne treba
	public function addMassAction(Varien_Event_Observer $observer)
	{
	    $block = $observer->getBlock();

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

            $this->getMassactionBlock()->addItem('delete_order', array(
                 'label'=> Mage::helper('sales')->__('Delete'),
                 'url'  => $this->getUrl('*/sales_order/massDelete'),
            ));
		return $this;
	}

}
