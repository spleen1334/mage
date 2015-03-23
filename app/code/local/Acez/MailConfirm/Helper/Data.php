<?php

class Acez_MailConfirm_Helper_Data extends Mage_Core_Helper_Abstract
{
	// XML Konstante za vrednosti
	const XML_PATH_ACTIVE = 'sales/acez_mailconfirm/active';
    const XML_PATH_NOTIFY_GENERAL_EMAIL = 'sales/acez_mailconfirm/notify_general_email';
    const XML_PATH_NOTIFY_SALES_EMAIL = 'sales/acez_mailconfirm/notify_sales_email';
    const XML_PATH_NOTIFY_SUPPORT_EMAIL = 'sales/acez_mailconfirm/notify_support_email';
    const XML_PATH_NOTIFY_CUSTOM1_EMAIL = 'sales/acez_mailconfirm/notify_custom1_email';
    const XML_PATH_NOTIFY_CUSTOM2_EMAIL = 'sales/acez_mailconfirm/notify_custom2_email';
    const XML_PATH_NOTIFY_EMAILS = 'sales/acez_mailconfirm/notify_emails';
    const XML_PATH_EMAIL_TEMPLATE = 'sales/acez_mailconfirm/email_template';

	// Sa getStoreConfig() se uzimaju vrednosti iz xml
	public function isModuleEnabled($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ACTIVE, $store);
    }

    public function getNotifyGeneralEmail($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFY_GENERAL_EMAIL, $store);
    }

    public function getNotifySalesEmail($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFY_SALES_EMAIL, $store);
    }

    public function getNotifySupportEmail($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFY_SUPPORT_EMAIL, $store);
    }

    public function getNotifyCustom1Email($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFY_CUSTOM1_EMAIL, $store);
    }

    public function getNotifyCustom2Email($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFY_CUSTOM2_EMAIL, $store);
    }
	
	// Uzmi podatke iz unosa, i formiraj email / name array
    public function getNotifyEmails($store = null)
    {
        $entries = Mage::getStoreConfig(self::XML_PATH_NOTIFY_EMAILS, $store);
        $emails = array();
        if (!empty($entries)) {
            $entries = explode(PHP_EOL, $entries);
            if (is_array($entries)) {
                foreach ($entries as $entry) {
                    $_entry = trim($entry);
                    $_name = trim(substr($_entry, 0, strpos($_entry, '<')));
                    $_email = trim(substr($_entry, strpos($_entry, '<')+1, -1));
                    if (!empty($_name) && !empty($_email)) {
                        $emails[] = array('name'=>$_name, 'email'=>$_email);
                    }
                }
            }
        }
        return $emails;
    }

	// Ucitaj template
    public function getEmailTemplate($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $store);
    }

    /**
	 * Ucitaj opciju iz configa
     * @param $identType ('general' or 'sales' or 'support' or 'custom1' or 'custom2')
     * @param $option ('name' or 'email')
     * @return string
     */
    public function getStoreEmailAddressSenderOption($identType, $option)
    {
        if (!$generalContactName = Mage::getSingleton('core/config_data')->getCollection()->getItemByColumnValue('path', 'trans_email/ident_'.$identType.'/'.$option)) {
            $conf = Mage::getSingleton('core/config')->init()->getXpath('/config/default/trans_email/ident_'.$identType.'/'.$option);
            $generalContactName = array_shift($conf);
        } else {
            $generalContactName = $generalContactName->getValue();
        }
        return (string)$generalContactName;
    }
}