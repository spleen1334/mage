<?php
class Magext_Logger_Model_Logger extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		$this->_init('magext_logger/logger');
	}
}