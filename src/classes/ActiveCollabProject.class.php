<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabProject class
 *
 */
class ActiveCollabProject extends ActiveCollabBaseObject {
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name');
	
	/**
	 * List of possible status
	 * 
	 * @var array
	 */
	protected $avaible_status = array(
	ACTIVECOLLAB_PROJECT_STATUS_ACTIVE,
	ACTIVECOLLAB_PROJECT_STATUS_PAUSED, 
	ACTIVECOLLAB_PROJECT_STATUS_COMPLETED, 
	ACTIVECOLLAB_PROJECT_STATUS_CANCELED
	);
	
	/**
	 * List of users ID to been add to project
	 * 
	 * @var array
	 */
	protected $users = false;
	/**
	 * Role id
	 * 
	 * @var integer
	 */
	protected $role_id;
	
	/**
	 * Permissions for user
	 * 
	 * @var array
	 */
	protected $permissions;
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @return object
	 */
	function __construct($project_id = null) {
		$this->object_name = 'Project';
		$this->setFlags();
		$this->project_id = $project_id;
		if($project_id) {
			$project = $this->getProject();
			if($project) {
				$this->object_details = $project; //object_details is array 
				if($project['leader']['id']) {
					$this->setLeaderID($project['leader']['id']);
				} // if
				$this->createObject();  //fill this object with values from returned array	
			} // if
		} else {
			$this->mandatory_fields[] = 'leader_id';
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
	 * Return project 
	 * 
	 * @param void
	 * @return Array
	 */
	private function getProject() {
		$path_info = '/projects/' . $this->project_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getProject
	
	/**
	 * Save project
	 * 
	 * @param void
	 * @return mixed - project object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->project_id == null ? '/projects/add' : '/projects/' . $this->project_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_PROJECT_STRING); //create params [project]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'project');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
	
	/**
	 * Delete project
	 * 
	 * @param void
	 * @return boolean - false on failure, true on success
	 */
	public function delete() {
		$path_info = '/projects/' . $this->project_id . '/delete';
		ActiveCollab::setRequestString($path_info); //format API url with given path info
		$param = $this->createParamsForCommonOp();
		$response = ActiveCollab::callAPI($param);
		if(empty($response)) {
			return true;
		}
		return $response;
	} // delete
	
	/**
	 * Set project status
	 * 
	 * @param $status - status string
	 * @return boolean - true on success false on failure
	 */
	public function changeStatus($status) {
		if($this->project_id != null) {
			if(in_array($status,$this->avaible_status)) {
				$path_info = '/projects/' . $this->project_id . '/edit-status';
				ActiveCollab::setRequestString($path_info); //format API url with given path info
				$this->setStatus($status);
				$post_params = $this->setParams(ACTIVECOLLAB_PARAM_PROJECT_STRING); //create params [project]
				$response = ActiveCollab::callAPI($post_params);
				if($response) {
					//$response = ActiveCollab::convertXMLToArray($response);
					return true;
				} // if
				return false;
			} else {
				throw new ActiveCollabCommonError(ERROR_MANDATORY_STATUS_NOT_VALID);
			} // if
	   } else {
	   		throw new ActiveCollabCommonError(ERROR_CHANGE_STATUS_FUNCTION_CALL);
	   } // if
	} // changeStatus
	
	/**
	 * Returns all tasks that are assigned to the logged in user in a particular project.
	 * 
	 * @param void
	 * @return object - ActiveCollabTicket object
	 */
	public function getUserTasks() {
		$path_info = '/projects/' . $this->project_id . '/user-tasks';
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response,'assignment');
		} // if
	} // getUserTasks
	
	/**
	 * Add one or more users to the project and set their permissions
	 * 
	 * @param void
	 * @return array
	 */
	private function saveUsers() {
		if($this->project_id != null) {
			if(is_array($this->users) && !empty($this->users)) {
				if(isset($this->role_id) || isset($this->permissions)) {
					return $this->saveUsersToProject();
				} else {
					throw new ActiveCollabCommonError(ERROR_USER_SET_PERMISSIONS_OR_ROLE_ID);
				} // if
			} else {
				throw new ActiveCollabCommonError(ERROR_USERS_SET);
			} // if
		} else {
			throw new ActiveCollabCommonError(ERROR_PROJECT_ISNT_SELECTED);
		} // if
	} // saveUsers
	
	/**
	 * Change permissions of selected user in a given project.
	 * 
	 * @param $user_id - user id
	 * @param $role - id of the project role or array of permission
	 * @return mixed - true if success,error if fail
	 */
	public function changeUserPermission($user_id = false,$role) {
		if($user_id) {
			if(is_array($role)) {
				$this->permissions = $role;
			} else {
				$this->role_id = $role;
			} // if
			$path_info = '/projects/' . $this->project_id . '/people/' . $user_id . '/change-permissions';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$params = $this->createUserParams();
			$response = ActiveCollab::callAPI($params); 
			return true;
		} else {
			throw new ActiveCollabCommonError(ERROR_USER_ID_EMPTY);
		} // if
	} // changeUserPermission
	
	/**
	 * Removes specific user from the project. 
	 * 
	 * @param $user_id - user id
	 * @return mixed - true on success, error message on fail
	 */
	public function removeUserFromProject($user_id = false) {
		if($user_id) {
			$path_info = '/projects/' . $this->project_id . '/people/' . $user_id . '/remove-from-project';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$params = $this->createParamsForCommonOp();
			$response = ActiveCollab::callAPI($params);
			return true;
		} else {
			throw new ActiveCollabCommonError(ERROR_USER_ID_EMPTY);
		} // if
	} // removeUserFromProject
	
	/**
	 * Add users to project
	 * 
	 * @param void
	 * @return mixed - true on success, error message on fail
	 */
	private function saveUsersToProject() {
		$pathInfo = '/projects/' . $this->project_id . '/people/add';
		ActiveCollab::setRequestString($pathInfo); //format API url with given path info
		$params = $this->createUserParams();
		$response = ActiveCollab::callAPI($params); 
		return true;
	} // saveUsersToProject
	
	/**
	 * Create user params
	 * 
	 * @param void
	 * @return array
	 */
	private function createUserParams() {
		$params = array();
		if(!empty($this->users)){
			foreach($this->users as $key) {
				$params['users'][] = $key;
			} // foreach	
		} // if		
		if(isset($this->role_id)) {
			$params['project_permissions']['role_id'] = $this->role_id;
		} else {
			if(!empty($this->permissions)){
				foreach ($this->permissions as $key => $value) {
					$params['project_permissions']['permissions'][$key] = $value;
				} // foreach
			} // if
		} // if
		$params['submitted'] = 'submitted';
		return $params;
	} // createUserParams
	
	/**
	 * Add users to project
	 * 
	 * @param $value - array of user id
	 * @param $role - id of the project role or array of permission
	 * @return array
	 */
	public function addUsers($value,$role) {
		if(is_array($value)){
			$this->users = $value;
			if(is_array($role)) {
				$this->permissions = $role;
			} else {
				$this->role_id = $role;
			} // if
			return $this->saveUsers();
		} // if
		else {
			throw new ActiveCollabCommonError(ERROR_USERS_SET);
		} // if
	} // setUsers
}

?>