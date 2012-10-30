<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabProjectGroup class
 *
 */
class ActiveCollabProjectGroup extends ActiveCollabBaseObject {
	/**
	 * projectGroupID
	 * 
	 * @var integer
	 */
	protected $group_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name');
	
	/**
	 * Construct the object
	 * 
	 * @param $group_id - group id
	 * @return object
	 */
	function __construct($group_id = null) {
		$this->object_name = 'Project group';
		$this->setFlags();
		$this->group_id = $group_id;
		if($group_id) {
			$group = $this->getGroup();
			if($group) {
				$this->object_details = $group; //userDetails is array 
				$this->createObject();  //fill this object with values from returned array	
			} // if
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
	 * Return group 
	 * 
	 * @param void
	 * @return array
	 */
	private function getGroup() {
		$path_info = 'projects/groups/' . $this->group_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getGroup
	
	/**
	 * Save group
	 * 
	 * @param void
	 * @return mixed - group object on success, or false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->group_id == null ? '/projects/groups/add' : '/projects/groups/' . $this->group_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_GROUP_STRING); //create params [user]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'project_group');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
	
	/**
	 * Delete group
	 * 
	 * @param void
	 * @return boolean - false on failure, true on success
	 */
	public function delete() {
		$path_info = '/projects/groups/' . $this->group_id  . '/delete';
		ActiveCollab::setRequestString($path_info); //format API url with given path info
		$param = $this->createParamsForCommonOp();
		$response = ActiveCollab::callAPI($param);
		if(empty($response)){
			return true;
		}
		return $response;
	} // delete
}

?>