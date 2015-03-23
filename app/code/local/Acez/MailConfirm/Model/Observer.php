<?php

class Acez_MailConfirm_Model_Observer
	extends Mage_Core_Helper_Abstract
{
	public function sendMailToList($observer)
	{
		// setup
		$order = $observer->getEvent()->getOrder();
		$storeId = $order->getStoreId();
		
		$helper = Mage::helper('acez_mailconfirm');

		if(!$helper->isModuleEnabled($storeId)) {
			return;
		}

		// TODO:
		// Ubaciti custom load za product attribute uz pomoc getStoreConfig u helperu
		// provera attr producta iz ordera
		$attrFound = false;
		// Selektuj sve iteme iz ordera
		$order->getAllVisibleItems();
		foreach($order as $product) {
			// mail_confirm je trazeni attribut
			if ($product->getMailConfirm()) {
				$attrFound = true;
				break;
			}
		}

		// Ukoliko je pronadjen attr onda sastavi mail, u suprotnom nista
		if ($attrFound) {
		try {
			// priprema
			$templateId = $helper->getEmailTemplate($storeId);
			$mailer = Mage::getModel('core/email_template_mailer');

			// Provera raznih opcija iz admina
			// Generisanje odgovarajucih mail parametara
//			if ($helper->getNotifyGeneralEmail()) {
//				$emailInfo = Mage::getModel('core/email_info');
//				$emailInfo->addTo($helper->getStoreEmailAddressSenderOption('general', 'email'), $helper->getStoreEmailAddressSenderOption('general', 'name'));
//				$mailer->addEmailInfo($emailInfo);
//			}
//
//			if ($helper->getNotifySalesEmail()) {
//                $emailInfo = Mage::getModel('core/email_info');
//                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('sales', 'email'), $helper->getStoreEmailAddressSenderOption('sales', 'name'));
//                $mailer->addEmailInfo($emailInfo);
//            }
//
//            if ($helper->getNotifySupportEmail()) {
//                $emailInfo = Mage::getModel('core/email_info');
//                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('support', 'email'), $helper->getStoreEmailAddressSenderOption('support', 'name'));
//                $mailer->addEmailInfo($emailInfo);
//            }
//
//            if ($helper->getNotifyCustom1Email()) {
//                $emailInfo = Mage::getModel('core/email_info');
//                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('custom1', 'email'), $helper->getStoreEmailAddressSenderOption('custom1', 'name'));
//                $mailer->addEmailInfo($emailInfo);
//            }
//
//            if ($helper->getNotifyCustom2Email()) {
//                $emailInfo = Mage::getModel('core/email_info');
//                $emailInfo->addTo($helper->getStoreEmailAddressSenderOption('custom2', 'email'), $helper->getStoreEmailAddressSenderOption('custom2', 'name'));
//                $mailer->addEmailInfo($emailInfo);
//			}

			// Ovde je sada lista mailova
			foreach($helper->getNotifyEmails() as $entry) {
				$emailInfo = Mage::getModel('core/email_info');
				$emailInfo->addTo($entry['email'], $entry['name']);
				$mailer->addEmailInfo($emailInfo);
			}

			// Pripremi Sendera
			$mailer->setSender(array(
				'name' => $helper->getStoreEmailAddressSenderOption('general', 'name'),
				'email'=> $helper->getStoreEmailAddressSenderOption('general', 'email'),
			));

			// Posalji mail
			$mailer->setStoreId($storeId);
			$mailer->setTemplateId($templateId);
			$mailer->setTemplateParams(array(
				'order' => $order,
			));

			$mailer->send();

		} catch (Exception $ex) {
			Mage::logException($ex);
		}
		}
	}
}