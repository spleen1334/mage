<?php

class Acez_EavGrid_Adminhtml_EavController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{

		$eavBlock = $this->getLayout()
			->createBlock('acez_eavgrid_adminhtml/eavent');

		$this->loadLayout()
			->_addContent($eavBlock)
			->renderLayout();
	}

	public function editAction()
	{
		$eav = Mage::getModel('inchoo_blog/post');

		if ($eavId = $this->getRequest()->getParam('id', false)) {
			$eav->load($eavId);

			if ($eav->getId() < 1) {
				$this->_getSession()->addError(
					$this->__('This EAV no longer exists')
				);

				return $this->_redirect('acez_eavgrid_admin/eav/index');
			}
		}

		if ($postData = $this->getRequest()->getPost('eavData')) {
			try {
				$eav->addData($postData);
				$eav->save();

				$this->getSession()->addSuccess(
					$this->__('EAV has been saved.')
				);

				return $this->_redirect(
					'acez_eavgrid_admin/eav/edit',
					array('id' => $eav->getId())
				);
			} catch (Exception $ex) {
				Mage::logException($ex);
				$this->_getSession()->addError($ex->getMessage());
			}
		}

		Mage::register('current_eav', $eav);

		$eavEditBlock = $this->getLayout()->createBlock(
			'acez_eavgrid_adminhtml/eavent_edit'
		);

		die($eavEditBlock->toHtml());


		$this->loadLayout()
			->_addContent($eavEditBlock)
			->renderLayout();
	}

	public function deleteAction()
	{
		$eav = Mage::getModel('acez_eavgrid/eav');

		if ($eavId = $this->getRequest()->getParam('id', false)) {
			$eav->load($eavId);
		}

		if ($eav->getId() < 1) {
			$this->_getSession()->addError(
				$this->__('This EAV no longer exists.')
			);

			return $this->_redirect('acez_eavgrid_admin/eav/index');
		}

		try {
			$eav->delete();
			$this->_getSession()->addSuccess(
				$this->__('EAV has been deleted.')
			);
		} catch (Exception $ex) {
			Mage::logException($ex);
			$this->_getSession()->addError($ex->getMessage());
		}

		return $this->_redirect('acez_eavgrid_admin/eav/index');
	}


	protected function _isAllowed()
	{
		$actionName = $this->getRequest()->getActionName();

		switch ($actionName) {
			case 'index':
			case 'edit':
			case 'delete':
				// namerno prazno, propada
			default:
				$adminSession = Mage::getSingleton('admin/session');
				$isAllowed = $adminSession->isAllowed('acez_eavgrid/eav');
				break;
		}

		return $isAllowed;
	}
}