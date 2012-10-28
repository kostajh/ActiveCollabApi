<?php

class ActiveCollabInvalidParamError extends Exception {
		
	/**
	 * Create and throw exeption
	 * 
	 * @param $variable_name
	 * @param $message
	 * @return false
	 */
	function __construct($variable_name,$message = false) {
		$this->message .= 'Invalid param value.';
		$this->message .=  nl2br("\n");
		$this->message .= $variable_name . ' is mandatory field and can`t be empty.';
		if($message) {
			$this->message .= $message;
		} // if
		parent::__construct($this->message);
	} // construct
} // ActiveCollabInvalidParamError

?>