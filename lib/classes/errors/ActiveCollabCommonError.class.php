<?php
define("ERROR_API_RESPONSE", 'API response error.');
define("ERROR_ATTACHMENTS_LIST",'Attachments list must be an array of files.');
define("ERROR_CHANGE_STATUS_FUNCTION_CALL",'In order to change project status you must firse select project.');
define("ERROR_USER_SET_PERMISSIONS",'User permissions must be an array.');
define("ERROR_USERS_SET",'Users list must be array of user IDs.');
define("ERROR_PROJECT_ISNT_SELECTED",'You must select project first.');
define("ERROR_USER_SET_PERMISSIONS_OR_ROLE_ID", 'You must set role id, or permissions for user.');
define("ERROR_USER_ID_EMPTY",'You must select user first.');
define("ERROR_MANDATORY_EMAIL_NOT_VALID",'Email address not valid, or mail host don`t exist.');
define("ERROR_MANDATORY_PASSWORD_NOT_VALID",'Password minimal length must be 3 characters, and can`t contain whitespaces.');
define("ERROR_MANDATORY_STATUS_NOT_VALID",'Status field must contain one of four possible values: active, paused, completed or canceled.');
define("ERROR_MANDATORY_PRIORITY_NOT_VALID",'Priority field must contain one of five possible values: -2, -1, 0, 1, 2.');

class ActiveCollabCommonError extends Exception {

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
} //ACCommonError

?>