<?php

class Acez_AdminGrid_Adminhtml_ColorController
	extends Mage_Adminhtml_Controller_Action
{
	// GRID CONTAINER lista
	public function indexAction()
	{
		// instancira grid container
		$colorBlock = $this->getLayout()->createBlock('acez_admingrid_adminhtml/color');

		// dodaje grid container kao jedini element na ovoj strani/akciji
		$this->loadLayout()
			->_addContent($colorBlock)
			->renderLayout();
	}

	// VIEW & EDIT postojecih entiteta
	public function editAction()
	{
		/*
		 * Uzima postojece podatke ukoliko postoji post 'id'
		 * U suprotnom pravi prazan obj 
		 */
		$color = Mage::getModel('acez_admingrid/color');
		if ($colorId = $this->getRequest()->getParam('id', false)) {
			$color->load($colorId);

			if ($color->getId() < 1) {
				$this->_getSession()->addError(
					$this->__('This color no longer exists.')
				);

				return $this->_redirect('acez_admingrid_admin/color/index');
			}
		}

		/*
		 * obradi $_POST podatke
		 */
		if ($postData = $this->getRequest()->getPost('colorData')) {
			try {
				$color->addData($postData);
				$color->save();

				$this->_getSession()->addSuccess( $this->__('The color has been saved'));

                // redirect to remove $_POST data from the request
                return $this->_redirect(
                    'acez_admingrid_admin/color/edit', 
                    array('id' => $color->getId())
				);

			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}

		}

		// mage registar global
		Mage::register('current_color', $color);

		// instanciraj form container
		// nejasna je color_edit, mislim da je i to objasnjeno u mage video
		// To se nalazi u form container klasi Edit.php
		$colorEditBlock = $this->getLayout()->createBlock('acez_admingrid_adminhtml/color_edit');


		// isto kao i za indexAction
		$this->loadLayout()
			->_addContent($colorEditBlock)
			->renderLayout();
		}

		public function deleteAction()
		{
			// slicno kao i u editAction
			$color = Mage::getModel('acez_admingrid/color');
			if ($colorId = $this->getRequest()->getParam('id', false)) {
				$color->load($colorId);
			}

			if ($color->getId() < 1) {
				$this->_getSession()->addError(
					$this->__('This color no longer exists')
				);

				return $this->_redirect('acez_admingrid_admin/color/index');
			}

			try {
				$color->delete();
				$this->_getSession()->addSuccess(
					$this->__('The color has been deleted!')
				);
			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}

			return $this->_redirect('acez_admingrid_admin/color/index');
		}

		// Ovo je za ACL, bez ovoga pravila u adminhtml.xml nemaju nikakvog efekta
		protected function _isAllowed()
		{
			$actionName = $this->getRequest()->getActionName();
			// switch je ubacen za potencijalne nadogradnje
			switch ($actionName) {
				case 'index':
				case 'edit':
				case 'delete':

				default:
					$adminSession = Mage::getSingleton('admin/session');
					$isAllowed = $adminSession->isAllowed('acez_admingrid/color');
					break;
			}

			return $isAllowed;
		}
}
