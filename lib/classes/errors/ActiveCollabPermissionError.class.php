<?php
define("ERROR_PERMISSION_COMPLETE_OBJECT",'can`t be completed.');
define("ERROR_PERMISSION_OPEN_OBJECT",'can`t be opened/reopened.');
define("ERROR_PERMISSION_STAR_OBJECT",'can`t be stared.');
define("ERROR_PERMISSION_UNSTAR_OBJECT",'can`t be unstared.');
define("ERROR_PERMISSION_SUBSCRIBE_OBJECT",'can`t be subscribed to user.');
define("ERROR_PERMISSION_UNSUBSCRIBED_OBJECT",'can`t be unsubscribed from user.');
define("ERROR_PERMISSION_MOVE_TO_TRASH_OBJECT",'can`t be move to trash.');
define("ERROR_PERMISSION_RESTORE_FROM_TRASH_OBJECT",'can`t be move to trash.');
define("ERROR_PERMISSION_CREATE_ASSIGNEE",'can`t have assignees.');
define("ERROR_PERMISSION_CREATE_SUBTASK",'can`t have subtask.');
define("ERROR_PERMISSION_CREATE_COMMENT",'can`t have comments.');
define("ERROR_PERMISSION_CREATE_ATTACHMENTS",'can`t have attachments.');
define("ERROR_PERMISSION_CREATE_USER",'can`t have users.');
define("ERROR_PERMISSION_HAVE_CATEGORIES",'can`t have categories.');

class ActiveCollabPermissionError extends Exception {
	
	/**
	 * Create and throw exeption
	 * 
	 * @param $object_name
	 * @param $message
	 * @return false
	 */
	function __construct($object_name,$message) {
		$this->message .= $object_name . ' ' . $message;
		parent::__construct($this->message);
	} // construct
} // ActiveCollabPermissionError


?>