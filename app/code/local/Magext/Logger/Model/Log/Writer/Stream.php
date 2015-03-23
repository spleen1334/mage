<?php
class Magext_Logger_Model_Log_Writer_Stream extends Zend_Log_Writer_Stream
{
	// logger file path
	private static $_flfp;
	
	public function __construct($streamOrUrl, $mode = NULL)
	{
		self::$_flfp = $streamOrUrl;
		return parent::__construct($streamOrUrl, $mode);
	}
	
	protected function _write($event)
	{
		$logger = Mage::getModel('magext_logger');
		
		$logger->setTimestamp($event['timestamp']);
		$logger->setMessage($event['message']);
		$logger->setPriority($event['priority']);
		$logger->setPriorityName($event['priorityName']);
		
		if (is_string(self::$_flfp)) {
			$logger->setFile(self::$_flfp);
		}
		
		try {
			$logger->save();
		} catch (Exception $e) {
			// die
		}
		
		return parent::_write($event);
	}
}