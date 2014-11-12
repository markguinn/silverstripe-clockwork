<?php
/**
 * Custom writer for SS_Log
 *
 * @author Ingo Schommer <ingo@silverstripe.com>
 * @package clockwork
 */

namespace Clockwork\Support\Silverstripe;
use Clockwork\Storage\FileStorage;
use Clockwork\Request\Log;
use Controller;
use SS_HTTPRequest;
use Psr\Log\LogLevel as LogLevel;

require_once 'Zend/Log/Writer/Abstract.php';

class ClockworkLogWriter extends \Zend_Log_Writer_Abstract {

	public static function factory($config) {
		return new Clockwork\Support\Silverstripe\ClockworkLogWriter();
	}

	public function _write($event) {
		$log = \Injector::inst()->get('ClockworkLog');

		// Map levels
		$levelMap = $this->getLevelMap();
		$level = $levelMap[$event['priorityName']];

		// Gather info
		$errstr = $event['message']['errstr'];
		$errfile = $event['message']['errfile'];
		$errline = $event['message']['errline'];
		$errcontext = $event['message']['errcontext'];
		$relfile = \Director::makeRelative($errfile);

		// Save message
		$message = "{$errstr} ({$relfile}:{$errline})";
		$log->log($level, $message, $errcontext);
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
