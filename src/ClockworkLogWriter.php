<?php
/**
 * Custom writer for SS_Log
 *
 * @author Ingo Schommer <ingo@silverstripe.com>
 * @package clockwork
 */

namespace Clockwork\Support\Silverstripe;
use Controller;
use Psr\Log\LogLevel as LogLevel;
use Injector;
use Director;

require_once 'Zend/Log/Writer/Abstract.php';

class ClockworkLogWriter extends \Zend_Log_Writer_Abstract {

	/**
	 * @param array|\Zend_Config $config
	 * @return ClockworkLogWriter
	 */
	public static function factory($config) {
		return new ClockworkLogWriter();
	}


	/**
	 * @param array $event
	 */
	public function _write($event) {
		/** @var \Clockwork\Request\Log $log */
		$log = Injector::inst()->get('ClockworkLog');

		// Map levels
		$levelMap = $this->getLevelMap();
		$level = $levelMap[$event['priorityName']];

		// Gather info
		$errstr = $event['message']['errstr'];
		$errfile = $event['message']['errfile'];
		$errline = $event['message']['errline'];
		$errcontext = $event['message']['errcontext'];
		$relfile = Director::makeRelative($errfile);

		// Save message
		$message = "{$errstr} ({$relfile}:{$errline})";
		$log->log($level, $message, is_array($errcontext) ? $errcontext : array($errcontext));
	}


	/**
	 * @see https://github.com/itsgoingd/clockwork/wiki/Development-notes
	 * @return array
	 */
	protected function getLevelMap() {
		return array(
			'ERR' => LogLevel::ERROR,
			'WARN' => LogLevel::WARNING,
			'NOTICE' => LogLevel::NOTICE,
			'INFO' => LogLevel::INFO,
			'DEBUG' => LogLevel::DEBUG,
		);
	}

}
