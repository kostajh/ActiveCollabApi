<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabStatusMessage class
 *
 */
class ActiveCollabStatusMessage extends ActiveCollabBaseObject {
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('message');
	
	/**
	 * Construct create object
	 * 
	 * @return object
	 */
	function __construct() {
		$this->object_name = 'Status message';
	} // construct
	
	/**
	 * Save status message
	 * 
	 * @param void
	 * @return mixed - status message object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = '/status/add';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_STATUS_STRING); //create params [status]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'message');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>