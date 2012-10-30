<?php
define('COMMAND_NOT_RECOGNIZED','Command not recognized. This command is available in version 2.3.1 and higher.');
class ActiveCollabCommandNotRecognized extends Exception {
	/**
	 * Create and throw exeption
	 * 
	 * @param $message
	 * @return false
	 */
	function __construct($message) {
		$this->message .= $message;
		parent::__construct($this->message);
	} // construct
}

?>