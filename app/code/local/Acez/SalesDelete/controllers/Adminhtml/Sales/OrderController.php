<?php

require_once 'Mage/Adminhtml/controllers/Sales/OrderController.php';

class Acez_SalesDelete_Adminhtml_Sales_OrderController
	extends Mage_Adminhtml_Sales_OrderController
{
	public function massDeleteAction()
	{
		// Orderi, ceo niz
        $orderIds = $this->getRequest()->getPost('order_ids', array());

		// Brisi order/e
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
			$order->delete();

			Mage::log($order->getId() . ' je izbrisan!!!');
        }

		// redirect nazad na grid
        $this->_redirect('*/*/');
	}
		
}
