<?php
class Magext_Logger_Adminhtml_Magext_LoggerController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout()->setActiveMenu('system/tools/magext_logger');
		$this->_addContent($this->getLayout()->createBlock('magext_logger/adminhtml_edit'));
		$this->renderLayout();
	}
	
	public function gridAction()
	{
		$this->getResponse()->setBody( $this->getLayout()->createBlock('magext_logger/adminhtml_grid')->toHtml());
	}
}