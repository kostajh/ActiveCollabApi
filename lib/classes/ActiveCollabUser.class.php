<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabUser class
 *
 */
class ActiveCollabUser extends ActiveCollabBaseObject {
	/**
	 * userID
	 * 
	 * @var integer
	 */
	protected $user_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('email');
	
	/**
	 * Construct the object
	 * 
	 * @param $company_id - company id
	 * @param $user_id - user id
	 * @return object
	 */
	function __construct($company_id = false, $user_id = null) {
		$this->object_name = 'User';
		$this->setFlags();
		$this->company_id = $company_id;
		$this->user_id = $user_id;
		if($user_id) {
			$user = $this->getUser();
			if($user) {
				$this->object_details = $user; //userDetails is array 
				$this->createObject();  //fill this object with values from returned array	
			} // if
		} else {
			$this->mandatory_fields[] = 'password';
		} // if
		return $this;
	} // construct
	
	/**
	 * Set flags - set object action permissions
	 * 
	 * @param void
	 * @return false
	 */
	private function setFlags() {
		
	} // setFlags
	
	/**
	 * Return user 
	 * 
	 * @param void
	 * @return array
	 */
	private function getUser() {
		$path_info = '/people/' . $this->company_id . '/users/' . $this->user_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getUser
	
	/**
	 * Save user
	 * 
	 * @param void
	 * @return mixed - user object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->user_id == null ? '/people/' . $this->company_id . '/add-user' : '/people/' . $this->company_id . '/users/' . $this->user_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_USER_STRING); //create params [user]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'user');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
	
	/**
	 * Delete user
	 * 
	 * @param void
	 * @return mixed - false on failure, status message on success
	 */
	public function delete() {
		$path_info = '/people/' . $this->company_id . '/users/' . $this->user_id . '/delete';
		ActiveCollab::setRequestString($path_info); //format API url with given path info
		$param = $this->createParamsForCommonOp();
		$response = ActiveCollab::callAPI($param);
		if(empty($response)) {
			return true;
		} // if
		return $response;
	} // delete
}

?>