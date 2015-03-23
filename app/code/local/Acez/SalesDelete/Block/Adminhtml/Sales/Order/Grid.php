<?php

class Acez_SalesDelete_Block_Adminhtml_Sales_Order_Grid
	extends Mage_Adminhtml_Block_Sales_Order_Grid
{
	protected function _prepareMassaction()
	{

		parent::_prepareMassaction();
//        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
            $this->getMassactionBlock()->addItem('delete_order', array(
                 'label'=> Mage::helper('sales')->__('Delete'),
                 'url'  => $this->getUrl('*/sales_order/massDelete'),
            ));
//        }

	}
}
