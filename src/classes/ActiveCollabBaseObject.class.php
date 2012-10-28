<?php

/**
 * ActiveCollabBaseObject class
 * 
 *  Contain all common operations
 */
class ActiveCollabBaseObject {
	/**
	 * Array of details
	 * 
	 * @var array
	 */
	protected $object_details = false;
	
	/**
	 * company_id
	 * 
	 * @var integer
	 */
	protected $company_id = null;
	/**
	 * ProjectId
	 * 
	 * @var integer
	 */
	protected $project_id = null;
	
	/**
	 * Object name
	 * 
	 * @var string
	 */
	protected $object_name; 
	
	/**
     * All table fields
     *
     * @var array
     */
	protected $fields = array(
	'id', 
	'type', 
	'source',
	'permalink', 
	'module', 
	'project_id', 
	'milestone_id', 
	'start_on', 
	'parent_id', 
	'parent_type', 
	'name', 
	'body', 
	'tags', 
	'state', 
	'visibility', 
	'priority', 
	'resolution', 
	'created_on', 
	'created_by_id', 
	'created_by_name', 
	'created_by_email', 
	'updated_on', 
	'updated_by_id', 
	'updated_by_name', 
	'updated_by_email', 
	'due_on', 
	'completed_on', 
	'completed_by_id', 
	'completed_by_name', 
	'completed_by_email', 
	'has_time', 
	'comments_count', 
	'is_locked', 
	'varchar_field_1', 
	'varchar_field_2', 
	'integer_field_1', 
	'integer_field_2', 
	'float_field_1', 
	'float_field_2', 
	'text_field_1', 
	'text_field_2', 
	'date_field_1', 
	'date_field_2', 
	'datetime_field_1', 
	'datetime_field_2', 
	'boolean_field_1', 
	'boolean_field_2', 
	'position', 
	'version',
	'ticket_id',
	'billable_status',
	'value',
	'record_date',
	'is_billable',
	'is_billed',
	'user_id',
	'office_address',
	'office_phone',
	'office_fax',
	'office_homepage',
	'company_id',
	'first_name',
	'last_name',
	'email',
	'last_visit_on',
	'role_id',
	'is_administrator',
	'is_project_manager',
	'is_people_manager',
	'token',
	'avatar_url',
	'password',
	'password_a',
	'overview',
	'default_visibility',
	'starts_on',
	'group_id',
	'leader_id',
	'status',
	'mime_type',
	'logo_url',
	'users',
	'company',
	'revisions',
	'logged_user_permissions',
	'icon_url',
	'permissions',
	'role',
	'projects',
	'revision_num',
	'subpages',
	'message');
    
    /**
     * List of assignees
     * 
     * @var array
     */
    protected $assignee_list;
    
    /**
     * ID of responsible assignee
     * 
     * @var integer
     */
    protected $assignee_responsible_id;

    /**
     * List of fields to be updated and sent as params
     * 
     * @var array
     */
    protected $field_for_update = array();
    
    /**
     * List of attachments
     * 
     * @var array
     */
    protected $attachments = false;
    
    /**
     * List of protected fields
     * 
     * @var array
     */
   	protected $protect = array(
  	  'id', 
  	  'type',
  	  'module',
  	  'parent_type',
  	  'state',
  	  'created_on',
  	  'updated_on', 
  	  'updated_by_id', 
  	  'updated_by_name', 
  	  'updated_by_email',
  	  'completed_on', 
  	  'completed_by_id', 
  	  'completed_by_name', 
  	  'completed_by_email', 
  	  'has_time',
  	  'position',
  	  'version'
  	);
  	
  	/**
  	 * List of seter function 
  	 * 
  	 * @var array
  	 */
    protected $seter_fields = array(
      'id' => 'setId', 
      'type' => 'setType',
	  'source' => 'setSource',
	  'module' => 'setModule',
	  'parent_id' => 'setParentId',
	  'project_id' => 'setProjectId',
	  'milestone_id' => 'setMilestoneId',
	  'parent_id' => 'setParentId', 
	  'parent_type' => 'setParentType',  
      'name' => 'setName',  
      'body' => 'setBody',  
      'tags' => 'setTags', 
      'state' => 'setState', 
      'visibility' => 'setVisibility',
	  'permalink' => 'setPermalink', 
      'priority' => 'setPriority', 
      'due_on' => 'setDueOn',
      'created_on' => 'setCreatedOn', 
      'created_by_id' => 'setCreatedById', 
      'created_by_name' => 'setCreatedByName', 
      'created_by_email' => 'setCreatedByEmail',
      'updated_on' => 'setUpdatedOn', 
      'updated_by_id' => 'setUpdatedById', 
      'completed_on' => 'setCompletedOn', 
      'completed_by_id' => 'setCompletedById', 
      'completed_by_name' => 'setCompletedByName', 
      'completed_by_email' => 'setCompletedByEmail',
      'position' => 'setPosition', 
      'version' => 'setVersion',
	  'ticket_id' => 'setTicketId',
	  'resolution' => 'setResolution',
      'has_time' => 'setHasTime',
      'comments_count' => 'setCommentsCount',
      'is_locked' => 'setIsLocked',
      'varchar_field_1' => 'setVarcharField1',
      'varchar_field_2' => 'setVarcharField2', 
      'integer_field_1' => 'setIntegerField1', 
      'integer_field_2' => 'setIntegerField2', 
      'float_field_1' => 'setFloatField1', 
      'float_field_2' => 'setFloatField2', 
      'text_field_1' => 'setTextField1', 
      'text_field_2' => 'setTextField2', 
      'date_field_1' => 'setDateField1', 
      'date_field_2' => 'setDateField2',
      'datetime_field_1' => 'setDateTimeField1', 
      'datetime_field_2' => 'setDateTimeField2', 
      'boolean_field_1' => 'setBooleanField1', 
      'boolean_field_2' => 'setBooleanField2',
      'assignees' => 'setAssignees',
      'start_on' => 'setStartOn',
      'billable_status' => 'setBillableStatus',
      'value' => 'setValue',
      'record_date' => 'setRecordDate',
      'is_billable' => 'setIsBillable',
      'is_billed' => 'setIsBilled',
      'user_id' => 'setUserId',
      'office_address' => 'setOfficeAddress',
      'office_phone' => 'setOfficePhone',
      'office_fax' => 'setOfficeFax',
      'office_homepage' => 'setOfficeHomepage',
      'company_id' => 'setCompanyId',
      'first_name' => 'setFirstName',
      'last_name' => 'setLastName',
      'email' => 'setEmail',
      'last_visit_on' => 'setLastVisitOn',
      'role_id' => 'setRoleId',
      'is_administrator' => 'setIsAdministrator',
      'is_project_manager' => 'setIsProjectManager',
      'is_people_manager' => 'setIsPeopleManager',
      'token' => 'setToken',
      'password' => 'setPassword',
      'avatar_url' => 'setAvatarURL',
      'password_a' => 'setPasswordA',
      'overview' => 'setOverview',
	  'default_visibility' => 'setDefaultVisibility',
	  'starts_on' => 'setStartsOn',
	  'group_id' => 'setGroupId',
	  'leader_id' => 'setLeaderId',
	  'status' => 'setStatus',
      'mime_type' => 'setMimeType',
      'logo_url' => 'setLogoUrl',
      'users' => 'setCompanyUsers',
   	  'company' => 'setCompany',
      'revisions' => 'setRevisions',
      'logged_user_permissions' => 'setLogedUserPermision',
      'icon_url' => 'setIconUrl',
      'permissions' => 'setPermissions',
      'role' => 'setRole',
      'projects' => 'setProjects',
      'revision_num' => 'setRevisionNumber',
      'subpages' => 'setSubPages',
      'message' => 'setMessage',
      'created_by' => 'setCreatedBy'      	    
    );
    
  	/**
  	 * List of get function 
  	 * 
  	 * @var array
  	 */
    protected $geter_fields = array(
      'id' => 'getId', 
      'type' => 'getType',
	  'source' => 'getSource',
	  'module' => 'getModule',
	  'parent_id' => 'getParentId',
	  'project_id' => 'getProjectId',
	  'milestone_id' => 'getMilestoneId',
	  'parent_id' => 'getParentId', 
	  'parent_type' => 'getParentType',  
      'name' => 'getName',  
      'body' => 'getBody',  
      'tags' => 'getTags', 
      'state' => 'getState', 
      'visibility' => 'getVisibility',
	  'permalink' => 'getPermalink', 
      'priority' => 'getPriority', 
      'due_on' => 'getDueOn',
      'created_on' => 'getCreatedOn', 
      'created_by_id' => 'getCreatedById', 
      'created_by_name' => 'getCreatedByName', 
      'created_by_email' => 'getCreatedByEmail',
      'updated_on' => 'getUpdatedOn', 
      'updated_by_id' => 'getUpdatedById', 
      'completed_on' => 'getCompletedOn', 
      'completed_by_id' => 'getCompletedById', 
      'completed_by_name' => 'getCompletedByName', 
      'completed_by_email' => 'getCompletedByEmail',
      'position' => 'getPosition', 
      'version' => 'getVersion',
	  'ticket_id' => 'getTicketId',
	  'resolution' => 'getResolution',
      'has_time' => 'getHasTime',
      'comments_count' => 'getCommentsCount',
      'is_locked' => 'getIsLocked',
      'varchar_field_1' => 'getVarcharField1',
      'varchar_field_2' => 'getVarcharField2', 
      'integer_field_1' => 'getIntegerField1', 
      'integer_field_2' => 'getIntegerField2', 
      'float_field_1' => 'getFloatField1', 
      'float_field_2' => 'getFloatField2', 
      'text_field_1' => 'getTextField1', 
      'text_field_2' => 'getTextField2', 
      'date_field_1' => 'getDateField1', 
      'date_field_2' => 'getDateField2',
      'datetime_field_1' => 'getDateTimeField1', 
      'datetime_field_2' => 'getDateTimeField2', 
      'boolean_field_1' => 'getBooleanField1', 
      'boolean_field_2' => 'getBooleanField2',
      'assignees' => 'getAssignees',
      'start_on' => 'getStartOn',
	  'billable_status' => 'getBillableStatus',
      'value' => 'getValue',
      'record_date' => 'getRecordDate',
      'is_billable' => 'getIsBillable',
      'is_billed' => 'getIsBilled',
      'user_id' => 'getUserId',
      'office_address' => 'getOfficeAddress',
      'office_phone' => 'getOfficePhone',
      'office_fax' => 'getOfficeFax',
      'office_homepage' => 'getOfficeHomepage',
      'company_id' => 'getCompanyId',
      'first_name' => 'getFirstName',
      'last_name' => 'getLastName',
      'email' => 'getEmail',
      'last_visit_on' => 'getLastVisitOn',
      'role_id' => 'getRoleId',
      'is_administrator' => 'getIsAdministrator',
      'is_project_manager' => 'getIsProjectManager',
      'is_people_manager' => 'getIsPeopleManager',
      'token' => 'getToken',
      'password' => 'getPassword',
      'avatar_url' => 'getAvatarURL',
      'password_a' => 'getPasswordA',
      'overview' => 'getOverview',
	  'default_visibility' => 'getDefaultVisibility',
	  'starts_on' => 'getStartsOn',
	  'group_id' => 'getGroupId',
	  'leader_id' => 'getLeaderId',
	  'status' => 'getStatus',
      'mime_type' => 'getMimeType',
      'logo_url' => 'getLogoUrl',
      'users' => 'getCompanyUsers',
      'company' => 'getCompany',
      'revisions' => 'getRevisions',
      'logged_user_permissions' => 'getLogedUserPermision',
      'icon_url' => 'getIconUrl',
      'permissions' => 'getPermissions',
      'role' => 'getRole',
      'projects' => 'getProjects',
      'revision_num' => 'getRevisionNumber',
      'subpages' => 'getSubPages',
      'message' => 'getMessage'      	          	                   	              	    
    );
	
    /**
     * Error messages for mandatory fields
     * 
     * @var array
     */
    private $error_message_mandatory_fields = array (
    	'name' => 'Name',
    	'body' => 'Body',
    	'parent_id' => 'Parent ID',
    	'user_id' => 'User ID',
    	'value' => 'Value',
    	'record_date' => 'Record Date',
    	'email' => 'Email address',
    	'password' => 'Password',
    	'leader_id' => 'Leader ID',
    	'start_on' => 'Start ON',
    	'due_on' => 'Due ON',
    	'message' => 'Status message'
    );
 	   
    /**
     * Can object be completed
     * 
     * @var boolean
     */
    protected $can_be_completed = false;
     /**
     * Can object be reopened
     * 
     * @var boolean
     */
    protected $can_be_reopened = false;
     /**
     * Can object be stared
     * 
     * @var boolean
     */
    protected $can_be_stared = true;
     /**
     * Can object be unstared
     * 
     * @var boolean
     */
    protected $can_be_unstared = true;
     /**
     * Can object be subscribed
     * 
     * @var boolean
     */
    protected $can_be_subscribed = false;
     /**
     * Can object be unsubscribed
     * 
     * @var boolean
     */
    protected $can_be_unsubscribed = false;
    /**
     * Can object be moved to trash
     * 
     * @var boolean
     */
   	protected $can_be_move_to_trash = true;
     /**
     * Can object be restored from trash
     * 
     * @var boolean
     */
    protected $can_be_restored_from_trash = true;
     /**
     * Can object have comments
     * 
     * @var boolean
     */
    protected $can_have_comments = false;
    /**
     * Can object have attachments
     * 
     * @var boolean
     */
    protected $can_have_attachments = false;
    /**
     * Can object have assignee
     * 
     * @var boolean
     */
    protected $can_have_assignees = false;
     /**
     * Can object have subtasks
     * 
     * @var boolean
     */
    protected $can_have_subtasks = false;
    /**
     * Can object have users
     * 
     * @var boolean
     */
    protected $can_have_users = false;

    /**
     * Can object have categories
     * 
     * @var boolean
     */
    protected $can_have_categories = false;
    
    /**
     * Change value in maped geter field with maped fields
     * 
     * @param void
     * @return false
     */
    protected function changeMapedFields() {
    	if(!empty($this->maped_fields)) {
    		foreach($this->maped_fields as $key => $value) {
    			if($this->geter_fields[$key]) {
    				$this->geter_fields[$key] = $this->geter_fields[$value];
    			} else {
    				$this->geter_fields[$key] = $value;
    			} //if
    		} // foreach
    	} // if
    } // changeMapedFields
    
    /**
     * Set object values
     * 
     * @param $arr - values array 
     * @return false
     */
    public function setObjectValues($arr) {
		if(is_array($arr) && !empty($arr)) {
			$this->object_details = $arr;
			$this->createObject();
		} // if
	} //setObjectValues
	
    /**
     * Validate all mandatory fields for object save
     * 
     * @param void
     * @return mixed - error message on fail, false on valid
     */
	protected function validateSave() {
		if(!empty($this->mandatory_fields)){
			foreach($this->mandatory_fields as $key) {
				if($this->geter_fields[$key]){
					$geter = (string)$this->geter_fields[$key];
					$tmp = $this->$geter();
					if(empty($tmp)) {
						return $this->error_message_mandatory_fields[$key];
					} // if
				} // if
			} // foreach
		} // if	
		return false;
	} // validateSave
	
	/**
	 * Fill object from array
	 * 
	 * @param void
	 * @return false
	 */
	protected function createObject() {
		if(is_array($this->object_details)) {
			foreach ($this->object_details as $key => $value) {
				$seter = (string)$this->seter_fields[$key];
				if($seter)
					$this->$seter($value);
			} // foreach	
		} // if
		$this->field_for_update = array();
	} // createObject
	
	/**
	 * Create params array
	 * 
	 * @param $param_name
	 * @return array
	 */
	protected function setParams($param_name) {
		$params[$param_name] = array();
		foreach($this->field_for_update as $key => $value) {
			$geter = (string)$value;
			$params[$param_name][$key] = $this->$geter();
		} // foreach
		if(!empty($params[$param_name])){
			$params['submitted'] = 'submitted';
			return $params;
		} else {
			return false;
		} // if
	} // setParams
	
	/**
	 * Check email
	 * 
	 * @param $mail_address
	 * @return boolean - true if valid and false if not
	 */
	protected function checkEmail($mail_address) {
	    $pattern = "/^[\w-]+(\.[\w-]+)*@";
	    $pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";
	    if (preg_match($pattern, $mail_address)) {
	    	return true;
	    } else {
	       return false;
	    } // if
	} // checkEmail
	
	/**
	 * Strip whitespaces from begining and from end and check password length
	 * 
	 * @param $password
	 * @return mixed - false on fail, trimed password on success
	 */
	protected function checkPassword($password){
		$password = trim($password);
		if(strlen($password) < 3)
			return false;
		return $password;
	} // checkPassword 
	
	/**
	 * Creates params used for common operations such are completeObject,openObject..
	 * 
	 * @param void
	 * @return array
	 */
	protected function createParamsForCommonOp() {
		$params['submitted'] = 'submitted';
		return $params;	
	} // createParamsForCommonOp
	
	/**
	 * Call API for common operations and return result
	 * 
	 * @param $path_info
	 * @return mixed - array on success, false on failed
	 */
	private function commonOperation($path_info) {
		ActiveCollab::setRequestString($path_info);
		$param = $this->createParamsForCommonOp();
		$response = ActiveCollab::callAPI($param);
		if($response) {
			$response = ActiveCollab::convertXMLToArray($response);
			return $response;
		} // if
		return false;
	} // commonOperation
	
	/**
	 * Marks specific object as completed
	 * 
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function completeObject() {
		if($this->can_be_completed) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/complete';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_COMPLETE_OBJECT);
		} // if
	} // completeObject
	
	/**
	 * Marks specific object as open
	 *
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function openObject() {
		if($this->can_be_reopened) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/open';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_OPEN_OBJECT);
		} // if
	} // openObject
	
	/**
	 * Marks specific object as starred
	 *
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function starObject() {
		if($this->can_be_stared) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/star';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_STAR_OBJECT);
		} // if
	} // starObject
	
	/**
	 * Marks specific object as unstared
	 *
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function unstarObject() {
		if($this->can_be_unstared) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/unstar';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_UNSTAR_OBJECT);
		} // if
	} // unstarObject
	
	/**
	 * Subscribe user to specific object
	 *
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function subscribeUser() {
		if($this->can_be_subscribed) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/subscribe';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_SUBSCRIBE_OBJECT);
		} // if
	} // subscribeObject
	
	/**
	 * Unsubscribe user to specific object
	 * 
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function unsubscribeUser() {
		if($this->can_be_unsubscribed) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/unsubscribe';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_UNSUBSCRIBED_OBJECT);
		} // if
	} // unsubscribeObject
	
	/**
	 * Move object to trash
	 * 
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function moveToTrash() {
		if($this->can_be_move_to_trash) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/move-to-trash';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_MOVE_TO_TRASH_OBJECT);
		} // if
	} // moveToTrash
	
	/**
	 * Restore object from trash
	 * 
	 * @param void
	 * @return mixed - array on success, false on failed
	 */
	public function restoreFromTrash() {
		if($this->can_be_restored_from_trash) {
			$pathInfo = '/projects/' . $this->getProjectId() . '/objects/' . $this->getId() . '/restore-from-trash';
			return $this->commonOperation($pathInfo);
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_RESTORE_FROM_TRASH_OBJECT);
		} // if
	} // restoreFromTrash
	
	/**
	 * Return object attachments
	 * 
	 * @param void
	 * @return array of ActiveCollabAttachment objects
	 */
	public function getAttachments() {
		if($this->can_have_attachments){
			if(!empty($this->object_details[ACTIVECOLLAB_ATTACHMENTS_STRING]))
				return ActiveCollab::makeArrayOfObject($this->object_details[ACTIVECOLLAB_ATTACHMENTS_STRING],'attachment');
			else
				return false;
		} else 
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_ATTACHMENTS);
	} // getAttachments
	
	/**
	 * Return object details
	 * 
	 * @param void
	 * @return array
	 */
	public function getDetails() {
		return $this->object_details;
	} // getDetails
	
	/**
	 * Create new subtask
	 * 
	 * @param void
	 * @return object - ActiveCollabSubTask object
	 */
	public function addNewSubTask() {
		if($this->can_have_subtasks) {
			$obj = new ActiveCollabSubTask($this->project_id);
			$obj->setParentId($this->getId());
			return $obj;
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_SUBTASK);
		} // if
	} // addNewSubTask
		
	/**
	 * Create new comment
	 * 
	 * @param void
	 * @return object - ActiveCollabComment object
	 */
	public function addNewComment() {
		if($this->can_have_comments) {
			$obj = new ActiveCollabComment($this->project_id);
			$obj->setParentId($this->getId());
			return $obj;
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_COMMENT);
		} // if
	} // addNewComment
		
	/**
     * Add attachments for object
     * 
     * @param $files - array of files
     * @return array
     */
    public function addAttachments($files) {
    	if($this->can_have_attachments) {
    		return $this->attachments = $files;
       	} else {
    		throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_ATTACHMENTS);
    	} // if
    } // addAttachments
    
	/**
	 * Create new user
	 * 
	 * @param void
	 * @return object - ActiveCollabUser object
	 */
	public function addNewUser() {
		if($this->can_have_users) {
			$obj = new ActiveCollabUser($this->company_id);
			return $obj;
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_USER);
		} // if
	} // addNewUser
	
	/**
	 * List object subtasks
	 * 
	 * @param void
	 * @return array of ActiveCollabSubTask objects
	 */
	public function getSubTasks() {
		if($this->can_have_subtasks)
			if(!empty($this->object_details[ACTIVECOLLAB_SUBTASKS_STRING]))
				return ActiveCollab::makeArrayOfObject($this->object_details[ACTIVECOLLAB_SUBTASKS_STRING],'task');	
			else
				return false;
		else 
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_SUBTASK);
	} // getSubTasks
		
	/**
	 * List object comments
	 * 
	 * @param void
	 * @return array of ActiveCollabComment objects
	 */
	public function getComments() {
		if($this->can_have_comments){
			if(!empty($this->object_details[ACTIVECOLLAB_COMMENTS_STRING]	))
				return ActiveCollab::makeArrayOfObject($this->object_details[ACTIVECOLLAB_COMMENTS_STRING],'comment');
			else
				return false;
		} else {
			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_COMMENT);
		} // if
	} // getComments
			
	/**
	 * Add field to be updated
	 * 
	 * @param $key
	 * @return false
	 */
	private function addFieldToBeUpdated($key) {
		if(!in_array($key,$this->protect)) {
			$this->field_for_update[$key] = $this->geter_fields[$key];
		} // if
	} // addFieldToBeUpdated
	
    /**
     * Set field value 
     * 
     * @param $name - name of field
     * @param $value - value of field
     * @return false
     */
    private function setFieldValue($name,$value) {
    	$set = $value;
    	$this->addFieldToBeUpdated($name);
    	switch($name) {
    		case 'id':
    			$set = intval($value);
    			break;
    		case 'type':
    			$set = strval($value);
          		break;
	        case 'source':
				$set = strval($value);
		        break;
	        case 'permalink':
	        	$set = strval($value);
	        	break;
	        case 'module':
	          	$set = strval($value);
	          	break;
	        case 'project_id':
	          	$set = intval($value);
	          	break;
	        case 'milestone_id':
	          	$set = intval($value);
	          	break;
	        case 'parent_id':
	          	$set = intval($value);
	          	break;
	        case 'parent_type':
	          	$set = strval($value);
	          	break;
	        case 'name':
	          	$set = strval($value);
	          	break;
	        case 'body':
	          	$set = strval($value);
	          	break;
	        case 'tags':
	          	$set = strval($value);
	          	break;
	        case 'state':
	          	$set = intval($value);
	          	break;
	        case 'visibility':
	          	$set = intval($value);
	          	break;
	        case 'priority':
	          	$set = intval($value);
	          	break;
	        case 'resolution':
	         	$set = strval($value);
	          	break;
	        case 'created_on':
	          	//$set = datetimeval($value);
	          	$set = $value;
	          	break;
	        case 'created_by_id':
	          	$set = intval($value);
	          	break;
	        case 'created_by_name':
	          	$set = strval($value);
	          	break;
	        case 'created_by_email':
	          	$set = strval($value);
	          	break;
	        case 'updated_on':
	          	//$set = datetimeval($value);
	          	$set = $value;
	          	break;
	        case 'updated_by_id':
	          	$set = intval($value);
	          	break;
	        case 'updated_by_name':
	          	$set = strval($value);
	          	break;
	        case 'updated_by_email':
	          	$set = strval($value);
	          	break;
	        case 'due_on':
	          	//$set = dateval($value);
	          	$set = $value;
	          	break;
	        case 'completed_on':
	          	//$set = datetimeval($value);
	          	$set = $value;
	          	break;
	        case 'completed_by_id':
	          	$set = intval($value);
	          	break;
	        case 'completed_by_name':
	          	$set = strval($value);
	          	break;
	        case 'completed_by_email':
	          	$set = strval($value);
	          	break;
	        case 'has_time':
	          	$set = boolval($value);
	          	break;
	        case 'comments_count':
	          	$set = intval($value);
	          	break;
	        case 'is_locked':
	          	$set = boolval($value);
	          	break;
	        case 'varchar_field_1':
	          	$set = strval($value);
	          	break;
	        case 'varchar_field_2':
	          	$set = strval($value);
	          	break;
	        case 'integer_field_1':
	          	$set = intval($value);
	          	break;
	        case 'integer_field_2':
	          	$set = intval($value);
	          	break;
	        case 'float_field_1':
	          	$set = floatval($value);
	          	break;
	        case 'float_field_2':
	          	$set = floatval($value);
	         	break;
	        case 'text_field_1':
	          	$set = strval($value);
	          	break;
	        case 'text_field_2':
	          	$set = strval($value);
	          	break;
	        case 'date_field_1':
	        	$set = $value;
	          	//$set = dateval($value);
	          	break;
	        case 'date_field_2':
	          	//$set = dateval($value);
	          	$set = $value;
	        	break;
	        case 'datetime_field_1':
	          	//$set = datetimeval($value);
	          	$set = $value;
	        	break;
	        case 'datetime_field_2':
	          	//$set = datetimeval($value);
	          	$set = $value;
	          	break;
	        case 'boolean_field_1':
	          	$set = boolval($value);
	          	break;
	        case 'boolean_field_2':
	          	$set = boolval($value);
	          	break;
	        case 'position':
	         	$set = intval($value);
	          	break;
	        case 'version':
	          	$set = intval($value);
	         	break;
	        case 'ticket_id':
	          	$set = intval($value);
	         	break;
	        case 'start_on':
	          	//$set = dateval($value);
	          	$set = $value;
	         	break;
	        case 'billable_status':
	        	$set = intval($value);
	        	break;
	        case 'value':
	        	$set = floatval($value);
	        	break;
	        case 'record_date':
	        	$set = $value;
	        	break;
	        case 'is_billable':
	        	$set = intval($value);
	        	break;
	        case 'is_billed':
	        	$set = intval($value);
	        	break;
	        case 'user_id':
	        	$set = intval($value);
	        	break;
	        case 'office_address':
	          	$set = strval($value);
	          	break;
	        case 'office_phone':
	          	$set = strval($value);
	          	break;
	        case 'office_fax':
	          	$set = strval($value);
	          	break;
	        case 'office_homepage':
	          	$set = strval($value);
	          	break;
	        case 'company_id':
	          	$set = intval($value);
	          	break;  	
	        case 'first_name':
	          	$set = strval($value);
	          	break;  	
	        case 'last_name':
	          	$set = strval($value);
	          	break;  	
	        case 'email':
	          	$set = strval($value);
	          	break;  	
	        case 'last_visit_on':
	          	$set = $value;
	          	break;  	
	        case 'role_id':
	          	$set = intval($value);
	          	break;  	
	        case 'is_administrator':
	          	$set = intval($value);
	          	break;
	        case 'is_project_manager':
	          	$set = intval($value);
	          	break;  	
	        case 'is_people_manager':
	          	$set = intval($value);
	          	break;  	
	        case 'token':
	          	$set = strval($value);
	          	break;
	        case 'avatar_url':
	        	$set = strval($value);
	        	break;
	        case 'password':
	        	$set = strval($value);
	        	break;
	        case 'password_a':
	        	$set = strval($value);
	        	break;
	        case 'overview':
	        	$set = strval($value);
	        	break;
	        case 'default_visibility':
	        	$set = intval($value);
	        	break;
	        case 'starts_on':
	        	//$set = dateval($value);
	        	$set = $value;
	        	break;
	        case 'group_id':
	        	$set = intval($value);
	        	break;
	        case 'leader_id':
	        	$set = intval($value);
	        	break;
	        case 'status':
	        	$set = strval($value);
	        	break;
	        case 'mime_type':
	        	$set = strval($value);
	        	break;
	        case 'logo_url':
	        	$set = strval($value);
	        	break;
	        case 'users':
	        	$set = $value;
	        	break;
	        case 'company':
	        	$set = $value;
	        	break;
	        case 'revisions':
	        	$set = $value;
	        	break;
	        case 'logged_user_permissions':
	        	$set = $value;
	        	break;
	        case 'icon_url':
	        	$set = strval($value);
	        	break;
	        case 'permissions':
	        	$set = $value;
	        	break;
	        case 'role':
	        	$set = strval($value);
	        	break;
	        case 'projects':
	        	$set = $value;
	        	break;
	        case 'revision_num':
	        	$set = intval($value);
	        	break;
	        case 'subpages':
	        	$set = $value;
	        	break;
	        case 'message':
	        	$set = strval($value);
	        	break;
	    } //switch
    	$this->fields[$name] = $set;
    } // setFieldValue
    
    /**
     * Return requested variable
     * 
     * @param $name
     * @return string
     */
    private function getFieldValue($name) {
    	return $this->fields[$name];	
    } // getFieldValue
    
    /**
     * Return value of id field
     *
     * @param void
     * @return integer
     */
    function getId() {
      return $this->getFieldValue('id');
    } // getId
    
    /**
     * Set value of id field
     *
     * @param integer $value
     * @return integer
     */
    protected function setId($value) {
      return $this->setFieldValue('id', $value);
    } // setId

    /**
     * Return value of type field
     *
     * @param void
     * @return string
     */
    function getType() {
      return $this->getFieldValue('type');
    } // getType
    
    /**
     * Set value of type field
     *
     * @param string $value
     * @return string
     */
    protected function setType($value) {
      return $this->setFieldValue('type', $value);
    } // setType

    /**
     * Return value of source field
     *
     * @param void
     * @return string
     */
    function getSource() {
      return $this->getFieldValue('source');
    } // getSource
    
    /**
     * Set value of source field
     *
     * @param string $value
     * @return string
     */
    function setSource($value) {
      return $this->setFieldValue('source', $value);
    } // setSource
    
	/**
     * Return value of permalink
     *
     * @param void
     * @return string
     */
    function getPermalink() {
      return $this->getFieldValue('permalink');
    } // getPermalink
    
    /**
     * Set value of permalink
     *
     * @param string $value
     * @return string
     */
    function setPermalink($value) {
      return $this->setFieldValue('permalink', $value);
    } // setPermalink
    
    /**
     * Return value of module field
     *
     * @param void
     * @return string
     */
    function getModule() {
      return $this->getFieldValue('module');
    } // getModule
    
    /**
     * Set value of module field
     *
     * @param string $value
     * @return string
     */
    function setModule($value) {
      return $this->setFieldValue('module', $value);
    } // setModule

    /**
     * Return value of project_id field
     *
     * @param void
     * @return integer
     */
    function getProjectId() {
      return $this->getFieldValue('project_id');
    } // getProjectId
    
    /**
     * Set value of project_id field
     *
     * @param integer $value
     * @return integer
     */
    protected function setProjectId($value) {
      return $this->setFieldValue('project_id', $value);
    } // setProjectId

    /**
     * Return value of milestone_id field
     *
     * @param void
     * @return integer
     */
    function getMilestoneId() {
      return $this->getFieldValue('milestone_id');
    } // getMilestoneId
    
    /**
     * Set value of milestone_id field
     *
     * @param integer $value
     * @return integer
     */
    function setMilestoneId($value) {
      return $this->setFieldValue('milestone_id', $value);
    } // setMilestoneId

    /**
     * Return value of parent_id field
     *
     * @param void
     * @return integer
     */
    function getParentId() {
      return $this->getFieldValue('parent_id');
    } // getParentId
    
    /**
     * Set value of parent_id field
     *
     * @param integer $value
     * @return integer
     */
    function setParentId($value) {
      return $this->setFieldValue('parent_id', $value);
    } // setParentId

    /**
     * Return value of parent_type field
     *
     * @param void
     * @return string
     */
    function getParentType() {
      return $this->getFieldValue('parent_type');
    } // getParentType
    
    /**
     * Set value of parent_type field
     *
     * @param string $value
     * @return string
     */
    protected function setParentType($value) {
      return $this->setFieldValue('parent_type', $value);
    } // setParentType

    /**
     * Return value of name field
     *
     * @param void
     * @return string
     */
    function getName() {
      return $this->getFieldValue('name');
    } // getName
    
    /**
     * Set value of name field
     *
     * @param string $value
     * @return string
     */
    function setName($value) {
      return $this->setFieldValue('name', $value);
    } // setName

    /**
     * Return value of body field
     *
     * @param void
     * @return string
     */
    function getBody() {
      return $this->getFieldValue('body');
    } // getBody
    
    /**
     * Set value of body field
     *
     * @param string $value
     * @return string
     */
    function setBody($value) {
      return $this->setFieldValue('body', $value);
    } // setBody

    /**
     * Return value of tags field
     *
     * @param void
     * @return string
     */
    function getTags() {
      return $this->getFieldValue('tags');
    } // getTags
    
    /**
     * Set value of tags field
     *
     * @param string $value
     * @return string
     */
    function setTags($value) {
      if(is_array($value)) {
      	if(ActiveCollab::isMultidimensionalArray($value)) {
      		$value = reset($value);
      	} // if
      	$value = implode(",",$value);
      } //if
      return $this->setFieldValue('tags', $value);
    } // setTags

    /**
     * Return value of state field
     *
     * @param void
     * @return integer
     */
    function getState() {
      return $this->getFieldValue('state');
    } // getState
    
    /**
     * Set value of state field
     *
     * @param integer $value
     * @return integer
     */
    protected function setState($value) {
      return $this->setFieldValue('state', $value);
    } // setState

    /**
     * Return value of visibility field
     *
     * @param void
     * @return integer
     */
    function getVisibility() {
      return $this->getFieldValue('visibility');
    } // getVisibility
    
    /**
     * Set value of visibility field
     *
     * @param integer $value
     * @return integer
     */
    function setVisibility($value) {
      return $this->setFieldValue('visibility', $value);
    } // setVisibility

    /**
     * Return value of priority field
     *
     * @param void
     * @return integer
     */
    function getPriority() {
      return $this->getFieldValue('priority');
    } // getPriority
    
    /**
     * Set value of priority field
     *
     * @param integer $value
     * @return integer
     */
    function setPriority($value) {
      	return $this->setFieldValue('priority', $value);
    } // setPriority

    /**
     * Return value of resolution field
     *
     * @param void
     * @return string
     */
    function getResolution() {
      return $this->getFieldValue('resolution');
    } // getResolution
    
    /**
     * Set value of resolution field
     *
     * @param string $value
     * @return string
     */
    function setResolution($value) {
      return $this->setFieldValue('resolution', $value);
    } // setResolution

    /**
     * Return value of created_on field
     *
     * @param void
     * @return DateTimeValue
     */
    function getCreatedOn() {
      return $this->getFieldValue('created_on');
    } // getCreatedOn
    
    /**
     * Set value of created_on field
     *
     * @param DateTimeValue $value
     * @return DateTimeValue
     */
    function setCreatedOn($value) {
      return $this->setFieldValue('created_on', $value);
    } // setCreatedOn

    /**
     * Return value of created_by_id field
     *
     * @param void
     * @return integer
     */
    function getCreatedById() {
      return $this->getFieldValue('created_by_id');
    } // getCreatedById
    
    /**
     * Set value of created_by_id field
     *
     * @param integer $value
     * @return integer
     */
    function setCreatedById($value) {
      return $this->setFieldValue('created_by_id', $value);
    } // setCreatedById

    /**
     * Return value of created_by_name field
     *
     * @param void
     * @return string
     */
    function getCreatedByName() {
      return $this->getFieldValue('created_by_name');
    } //getCreatedByName
    
    /**
     * Set value of created_by_name field
     *
     * @param string $value
     * @return string
     */
    function setCreatedByName($value) {
      return $this->setFieldValue('created_by_name', $value);
    } // setCreatedByName

    /**
     * Return value of created_by_email field
     *
     * @param void
     * @return string
     */
    function getCreatedByEmail() {
      return $this->getFieldValue('created_by_email');
    } // getCreatedByEmail
    
    /**
     * Set value of created_by_email field
     *
     * @param string $value
     * @return string
     */
    function setCreatedByEmail($value) {
    	if($this->checkEmail($value))
   		   return $this->setFieldValue('created_by_email', $value);
       	else
    		throw new ActiveCollabCommonError(ERROR_MANDATORY_EMAIL_NOT_VALID);
    } // setCreatedByEmail

    /**
     * Return value of updated_on field
     *
     * @param void
     * @return DateTimeValue
     */
    function getUpdatedOn() {
      return $this->getFieldValue('updated_on');
    } // getUpdatedOn
    
    /**
     * Set value of updated_on field
     *
     * @param DateTimeValue $value
     * @return DateTimeValue
     */
    protected function setUpdatedOn($value) {
      return $this->setFieldValue('updated_on', $value);
    } // setUpdatedOn

    /**
     * Return value of updated_by_id field
     *
     * @param void
     * @return integer
     */
    function getUpdatedById() {
      return $this->getFieldValue('updated_by_id');
    } // getUpdatedById 
    
    /**
     * Set value of updated_by_id field
     *
     * @param integer $value
     * @return integer
     */
    protected function setUpdatedById($value) {
      return $this->setFieldValue('updated_by_id', $value);
    } // setUpdatedById 

    /**
     * Return value of updated_by_name field
     *
     * @param void
     * @return string
     */
    function getUpdatedByName() {
      return $this->getFieldValue('updated_by_name');
    } // getUpdatedByName
    
    /**
     * Set value of updated_by_name field
     *
     * @param string $value
     * @return string
     */
    protected function setUpdatedByName($value) {
      return $this->setFieldValue('updated_by_name', $value);
    } // setUpdatedByName

    /**
     * Return value of updated_by_email field
     *
     * @param void
     * @return string
     */
    function getUpdatedByEmail() {
      return $this->getFieldValue('updated_by_email');
    } // getUpdatedByEmail
    
    /**
     * Set value of updated_by_email field
     *
     * @param string $value
     * @return string
     */
    protected function setUpdatedByEmail($value) {
      return $this->setFieldValue('updated_by_email', $value);
    } // setUpdatedByEmail

    /**
     * Return value of due_on field
     *
     * @param void
     * @return DateValue
     */
    function getDueOn() {
      return $this->getFieldValue('due_on');
    } // getDueOn
    
    /**
     * Set value of due_on field
     *
     * @param DateValue $value
     * @return DateValue
     */
    function setDueOn($value) {
      return $this->setFieldValue('due_on', $value);
    } // setDueOn

    /**
     * Return value of completed_on field
     *
     * @param void
     * @return DateTimeValue
     */
    function getCompletedOn() {
      return $this->getFieldValue('completed_on');
    } // getCompletedOn
    
    /**
     * Set value of completed_on field
     *
     * @param DateTimeValue $value
     * @return DateTimeValue
     */
    protected function setCompletedOn($value) {
      return $this->setFieldValue('completed_on', $value);
    } // setCompletedOn

    /**
     * Return value of completed_by_id field
     *
     * @param void
     * @return integer
     */
    function getCompletedById() {
      return $this->getFieldValue('completed_by_id');
    } // getCompletedById
    
    /**
     * Set value of completed_by_id field
     *
     * @param integer $value
     * @return integer
     */
    protected function setCompletedById($value) {
      return $this->setFieldValue('completed_by_id', $value);
    } // setCompletedById

    /**
     * Return value of completed_by_name field
     *
     * @param void
     * @return string
     */
    function getCompletedByName() {
      return $this->getFieldValue('completed_by_name');
    } // getCompletedByName
    
    /**
     * Set value of completed_by_name field
     *
     * @param string $value
     * @return string
     */
    protected function setCompletedByName($value) {
      return $this->setFieldValue('completed_by_name', $value);
    } // getCompletedByName

    /**
     * Return value of completed_by_email field
     *
     * @param void
     * @return string
     */
    function getCompletedByEmail() {
      return $this->getFieldValue('completed_by_email');
    } // getCompletedByEmail
    
    /**
     * Set value of completed_by_email field
     *
     * @param string $value
     * @return string
     */
    protected function setCompletedByEmail($value) {
      return $this->setFieldValue('completed_by_email', $value);
    } // setCompletedByEmail

    /**
     * Return value of has_time field
     *
     * @param void
     * @return boolean
     */
    function getHasTime() {
      return $this->getFieldValue('has_time');
    } // getHasTime
    
    /**
     * Set value of has_time field
     *
     * @param boolean $value
     * @return boolean
     */
    protected function setHasTime($value) {
      return $this->setFieldValue('has_time', $value);
    } // setHasTime

    /**
     * Return value of comments_count field
     *
     * @param void
     * @return integer
     */
    function getCommentsCount() {
      return $this->getFieldValue('comments_count');
    } // getCommentsCount
    
    /**
     * Set value of comments_count field
     *
     * @param integer $value
     * @return integer
     */
    function setCommentsCount($value) {
      return $this->setFieldValue('comments_count', $value);
    } // setCommentsCount

    /**
     * Return value of is_locked field
     *
     * @param void
     * @return boolean
     */
    function getIsLocked() {
      return $this->getFieldValue('is_locked');
    } // getIsLocked
    
    /**
     * Set value of is_locked field
     *
     * @param boolean $value
     * @return boolean
     */
    function setIsLocked($value) {
      return $this->setFieldValue('is_locked', $value);
    } // setIsLocked

    /**
     * Return value of varchar_field_1 field
     *
     * @param void
     * @return string
     */
    function getVarcharField1() {
      return $this->getFieldValue('varchar_field_1');
    } // getVarcharField1
    
    /**
     * Set value of varchar_field_1 field
     *
     * @param string $value
     * @return string
     */
    function setVarcharField1($value) {
      return $this->setFieldValue('varchar_field_1', $value);
    } // setVarcharField1

    /**
     * Return value of varchar_field_2 field
     *
     * @param void
     * @return string
     */
    function getVarcharField2() {
      return $this->getFieldValue('varchar_field_2');
    } // getVarcharField2
    
    /**
     * Set value of varchar_field_2 field
     *
     * @param string $value
     * @return string
     */
    function setVarcharField2($value) {
      return $this->setFieldValue('varchar_field_2', $value);
    } // setVarcharField2

    /**
     * Return value of integer_field_1 field
     *
     * @param void
     * @return integer
     */
    function getIntegerField1() {
      return $this->getFieldValue('integer_field_1');
    } // getIntegerField1
    
    /**
     * Set value of integer_field_1 field
     *
     * @param integer $value
     * @return integer
     */
    function setIntegerField1($value) {
      return $this->setFieldValue('integer_field_1', $value);
    } // setIntegerField1

    /**
     * Return value of integer_field_2 field
     *
     * @param void
     * @return integer
     */
    function getIntegerField2() {
      return $this->getFieldValue('integer_field_2');
    } // getIntegerField2
    
    /**
     * Set value of integer_field_2 field
     *
     * @param integer $value
     * @return integer
     */
    function setIntegerField2($value) {
      return $this->setFieldValue('integer_field_2', $value);
    } // setIntegerField2

    /**
     * Return value of float_field_1 field
     *
     * @param void
     * @return float
     */
    function getFloatField1() {
      return $this->getFieldValue('float_field_1');
    } // getFloatField1
    
    /**
     * Set value of float_field_1 field
     *
     * @param float $value
     * @return float
     */
    function setFloatField1($value) {
      return $this->setFieldValue('float_field_1', $value);
    } // setFloatField1

    /**
     * Return value of float_field_2 field
     *
     * @param void
     * @return float
     */
    function getFloatField2() {
      return $this->getFieldValue('float_field_2');
    } // getFloatField2
    
    /**
     * Set value of float_field_2 field
     *
     * @param float $value
     * @return float
     */
    function setFloatField2($value) {
      return $this->setFieldValue('float_field_2', $value);
    } // setFloatField2

    /**
     * Return value of text_field_1 field
     *
     * @param void
     * @return string
     */
    function getTextField1() {
      return $this->getFieldValue('text_field_1');
    } // getTextField1
    
    /**
     * Set value of text_field_1 field
     *
     * @param string $value
     * @return string
     */
    function setTextField1($value) {
      return $this->setFieldValue('text_field_1', $value);
    } // setTextField1
 
    /**
     * Return value of text_field_2 field
     *
     * @param void
     * @return string
     */
    function getTextField2() {
      return $this->getFieldValue('text_field_2');
    } // getTextField2
    
    /**
     * Set value of text_field_2 field
     *
     * @param string $value
     * @return string
     */
    function setTextField2($value) {
      return $this->setFieldValue('text_field_2', $value);
    } // setTextField2

    /**
     * Return value of date_field_1 field
     *
     * @param void
     * @return DateValue
     */
    function getDateField1() {
      return $this->getFieldValue('date_field_1');
    } // getDateField1
    
    /**
     * Set value of date_field_1 field
     *
     * @param DateValue $value
     * @return DateValue
     */
    function setDateField1($value) {
      return $this->setFieldValue('date_field_1', $value);
    } // setDateField1

    /**
     * Return value of date_field_2 field
     *
     * @param void
     * @return DateValue
     */
    function getDateField2() {
      return $this->getFieldValue('date_field_2');
    } // getDateField2
    
    /**
     * Set value of date_field_2 field
     *
     * @param DateValue $value
     * @return DateValue
     */
    function setDateField2($value) {
      return $this->setFieldValue('date_field_2', $value);
    } // setDateField2

    /**
     * Return value of datetime_field_1 field
     *
     * @param void
     * @return DateTimeValue
     */
    function getDatetimeField1() {
      return $this->getFieldValue('datetime_field_1');
    } // getDatetimeField1
    
    /**
     * Set value of datetime_field_1 field
     *
     * @param DateTimeValue $value
     * @return DateTimeValue
     */
    function setDatetimeField1($value) {
      return $this->setFieldValue('datetime_field_1', $value);
    } // setDatetimeField1

    /**
     * Return value of datetime_field_2 field
     *
     * @param void
     * @return DateTimeValue
     */
    function getDatetimeField2() {
      return $this->getFieldValue('datetime_field_2');
    } // getDatetimeField2
    
    /**
     * Set value of datetime_field_2 field
     *
     * @param DateTimeValue $value
     * @return DateTimeValue
     */
    function setDatetimeField2($value) {
      return $this->setFieldValue('datetime_field_2', $value);
    } // setDatetimeField2

    /**
     * Return value of boolean_field_1 field
     *
     * @param void
     * @return boolean
     */
    function getBooleanField1() {
      return $this->getFieldValue('boolean_field_1');
    } // getBooleanField1
    
    /**
     * Set value of boolean_field_1 field
     *
     * @param boolean $value
     * @return boolean
     */
    function setBooleanField1($value) {
      return $this->setFieldValue('boolean_field_1', $value);
    } // setBooleanField1

    /**
     * Return value of boolean_field_2 field
     *
     * @param void
     * @return boolean
     */
    function getBooleanField2() {
      return $this->getFieldValue('boolean_field_2');
    } // getBooleanField2
    
    /**
     * Set value of boolean_field_2 field
     *
     * @param boolean $value
     * @return boolean
     */
    function setBooleanField2($value) {
      return $this->setFieldValue('boolean_field_2', $value);
    } // setBooleanField2

    /**
     * Return value of position field
     *
     * @param void
     * @return integer
     */
    function getPosition() {
      return $this->getFieldValue('position');
    } // getPosition
    
    /**
     * Set value of position field
     *
     * @param integer $value
     * @return integer
     */
    protected function setPosition($value) {
      return $this->setFieldValue('position', $value);
    } // setPosition

    /**
     * Return value of version field
     *
     * @param void
     * @return integer
     */
    function getVersion() {
      return $this->getFieldValue('version');
    } // getVersion
    
    /**
     * Set value of version field
     *
     * @param integer $value
     * @return integer
     */
    protected function setVersion($value) {
      return $this->setFieldValue('version', $value);
    } // setVersion
    
	/**
     * Return value of ticket_id
     *
     * @param void
     * @return integer
     */
    function getTicketId() {
      return $this->getFieldValue('ticket_id');
    } // getTicketId
    
    /**
     * Set value of ticket_id
     *
     * @param integer $value
     * @return integer
     */
    protected function setTicketId($value) {
      return $this->setFieldValue('ticket_id', $value);
    } // setTicketId

	/**
     * Return value of startOn
     *
     * @param void
     * @return date
     */
    function getStartOn() {
      return $this->getFieldValue('start_on');
    } // getStartOn
    
    /**
     * Set value of startOn
     *
     * @param date $value
     * @return date
     */
    function setStartOn($value) {
      return $this->setFieldValue('start_on', $value);
    } // setStartOn
    
    /**
     * Return value of billable status
     *
     * @param void
     * @return integer
     */
    function getBillableStatus() {
    	return $this->getFieldValue('billable_status');
    } // getBillableStatus
    
	/**
     * Set value of billable status
     *
     * @param integer $value
     * @return integer
     */
    function setBillableStatus($value) {
    	return $this->setFieldValue('billable_status', $value);
    } // setBillableStatus
    
    /**
     * Return value of value
     *
     * @param void
     * @return float
     */
    function getValue() {
    	return $this->getFieldValue('value');
    } // getValue
    
    /**
     * Set value of value
     *
     * @param float $value
     * @return float
     */
    function setValue($value) {
    	return $this->setFieldValue('value', $value);
    } // setValue
    
    /**
     * Return value of record date
     *
     * @param void
     * @return date
     */
    function getRecordDate() {
    	return $this->getFieldValue('record_date');
    } // getRecordDate
    
    /**
     * Set value of record date
     *
     * @param date $value
     * @return date
     */
    function setRecordDate($value) {
    	return $this->setFieldValue('record_date', $value);
    } // setRecordDate
    
    /**
     * Return value of is billable
     *
     * @param void
     * @return integer
     */
    function getIsBillable() {
    	return $this->getFieldValue('is_billable');
    } // getIsBillable
    
    /**
     * Set value of is billable
     *
     * @param integer $value
     * @return integer
     */
    function setIsBillable($value) {
    	return $this->setFieldValue('is_billable', $value);
    } // setIsBillable
    
    /**
     * Return value of is billed
     *
     * @param void
     * @return integer
     */
    function getIsBilled() {
    	return $this->getFieldValue('is_billed');
    } // getIsBilled
    
    /**
     * Set value of is billed
     *
     * @param integer $value
     * @return integer
     */
    function setIsBilled($value) {
    	return $this->setFieldValue('is_billed', $value);
    } // setIsBilled
	
    /**
     * Return value of user id
     *
     * @param void
     * @return integer
     */
    function getUserId() {
    	return $this->getFieldValue('user_id');
    } // getUserID
    
    /**
     * Set value of user id
     *
     * @param integer $value
     * @return integer
     */
    function setUserId($value) {
    	return $this->setFieldValue('user_id', $value);
    } // setUserId
    
	/**
     * Return value of office_address
     *
     * @param void
     * @return string
     */
    function getOfficeAddress() {
    	return $this->getFieldValue('office_address');
    } // getOfficeAddress
    
    /**
     * Set value of office_address
     *
     * @param string $value
     * @return string
     */
    function setOfficeAddress($value) {
    	return $this->setFieldValue('office_address', $value);
    } // setOfficeAddress
    
	/**
     * Return value of office_phone
     *
     * @param void
     * @return string
     */
    function getOfficePhone() {
    	return $this->getFieldValue('office_phone');
    } // getOfficePhone
    
    /**
     * Set value of office_phone
     *
     * @param string $value
     * @return string
     */
    function setOfficePhone($value) {
    	return $this->setFieldValue('office_phone', $value);
    } // setOfficePhone
   
    /**
     * Return value of office_fax
     *
     * @param void
     * @return string
     */
    function getOfficeFax() {
    	return $this->getFieldValue('office_fax');
    } // getOfficeFax
    
    /**
     * Set value of office_fax
     *
     * @param string $value
     * @return string
     */
    function setOfficeFax($value) {
    	return $this->setFieldValue('office_fax', $value);
    } // setOfficeFax
   
 	/**
     * Return value of office_homepage
     *
     * @param void
     * @return string
     */
    function getOfficeHomepage() {
    	return $this->getFieldValue('office_homepage');
    } // getOfficeHomepage
    
    /**
     * Set value of office_homepage
     *
     * @param string $value
     * @return string
     */
    function setOfficeHomepage($value) {
    	return $this->setFieldValue('office_homepage', $value);
    } // setOfficeHomepage
    
	/**
     * Return value of company_id
     *
     * @param void
     * @return integer
     */
    function getCompanyId() {
    	return $this->getFieldValue('company_id');
    } // getCompanyId
    
    /**
     * Set value of company_id
     *
     * @param integer $value
     * @return integer
     */
    function setCompanyId($value) {
    	return $this->setFieldValue('company_id', $value);
    } // setCompanyId
    
	/**
     * Return value of first_name
     *
     * @param void
     * @return string
     */
    function getFirstName() {
    	return $this->getFieldValue('first_name');
    } // getFirstName
    
    /**
     * Set value of first_name
     *
     * @param string $value
     * @return string
     */
    function setFirstName($value) {
    	return $this->setFieldValue('first_name', $value);
    } // setFirstName
    
	/**
     * Return value of last_name
     *
     * @param void
     * @return string
     */
    function getLastName() {
    	return $this->getFieldValue('last_name');
    } // getLastName
    
    /**
     * Set value of last_name
     *
     * @param string $value
     * @return string
     */
    function setLastName($value) {
    	return $this->setFieldValue('last_name', $value);
    } // setLastName
    
    /**
     * Return value of email
     *
     * @param void
     * @return string
     */
    function getEmail() {
    	return $this->getFieldValue('email');
    } // getEmail
    
    /**
     * Set value of email
     *
     * @param string $value
     * @return string
     */
    function setEmail($value) {
    	if($this->checkEmail($value))
    		return $this->setFieldValue('email', $value);
    	else
    		throw new ActiveCollabCommonError(ERROR_MANDATORY_EMAIL_NOT_VALID);
    } // setEmail

    /**
     * Return value of last_visit_on
     *
     * @param void
     * @return date
     */
    function getLastVisitOn() {
    	return $this->getFieldValue('last_visit_on');
    } // getLastVisitOn
    
    /**
     * Set value of last_visit_on
     *
     * @param date $value
     * @return date
     */
    protected function setLastVisitOn($value) {
    	return $this->setFieldValue('last_visit_on', $value);
    } // setLastVisitOn
    
	/**
     * Return value of role_id
     *
     * @param void
     * @return integer
     */
    function getRoleId() {
    	return $this->getFieldValue('role_id');
    } // getRoleId
    
    /**
     * Set value of role_id
     *
     * @param integer $value
     * @return integer
     */
    function setRoleId($value) {
    	return $this->setFieldValue('role_id', $value);
    } // setRoleId
    
	/**
     * Return value of is_administrator
     *
     * @param void
     * @return integer
     */
    function getIsAdministrator() {
    	return $this->getFieldValue('is_administrator');
    } // getIsAdministrator
    
    /**
     * Set value of is_administrator
     *
     * @param integer $value
     * @return integer
     */
    function setIsAdministrator($value) {
    	return $this->setFieldValue('is_administrator', $value);
    } // setIsAdministrator
   
	/**
     * Return value of is_project_manager
     *
     * @param void
     * @return integer
     */
    function getIsProjectManager() {
    	return $this->getFieldValue('is_project_manager');
    } // getIsProjectManager
    
    /**
     * Set value of is_project_manager
     *
     * @param integer $value
     * @return integer
     */
    function setIsProjectManager($value) {
    	return $this->setFieldValue('is_project_manager', $value);
    } // setIsProjectManager
   
	/**
     * Return value of is_people_manager
     *
     * @param void
     * @return integer
     */
    function getIsPeopleManager() {
    	return $this->getFieldValue('is_people_manager');
    } // getIsPeopleManager
    
    /**
     * Set value of is_people_manager
     *
     * @param integer $value
     * @return integer
     */
    function setIsPeopleManager($value) {
    	return $this->setFieldValue('is_people_manager', $value);
    } // setIsPeopleManager
    
	/**
     * Return value of token
     *
     * @param void
     * @return string
     */
    function getToken() {
    	return $this->getFieldValue('token');
    } // getToken
    
    /**
     * Set value of token
     *
     * @param string $value
     * @return string
     */
    protected function setToken($value) {
    	return $this->setFieldValue('token', $value);
    } // setToken
    
	/**
     * Return value of password
     *
     * @param void
     * @return string
     */
    function getPassword() {
    	return $this->getFieldValue('password');
    } // getPassword
    
    /**
     * Set value of password
     *
     * @param string $value
     * @return string
     */
    function setPassword($value) {
    	if($this->checkPassword($value)){
    		$this->setFieldValue('password', $this->checkPassword($value));
    		return $this->setFieldValue('password_a', $this->checkPassword($value));
    	} else {
    		throw new ActiveCollabCommonError(ERROR_MANDATORY_PASSWORD_NOT_VALID);
    	} // if
    } // setPassword
    
	/**
     * Return value of passwordA
     *
     * @param void
     * @return string
     */
    function getPasswordA() {
    	return $this->getFieldValue('password_a');
    } // getPasswordA
    
    /**
     * Set value of passwordA
     *
     * @param string $value
     * @return string
     */
    function setPasswordA($value) {
    	if($this->checkPassword($value))
    		return $this->setFieldValue('password_a', $this->checkPassword($value));
    	else
    		throw new ActiveCollabCommonError(ERROR_MANDATORY_PASSWORD_NOT_VALID);
    } // setPasswordA
    
	/**
     * Return value of avatar url
     *
     * @param void
     * @return string
     */
    function getAvatarURL() {
    	return $this->getFieldValue('avatar_url');
    } // getAvatarURL
    
    /**
     * Set value of avatar url
     *
     * @param string $value
     * @return string
     */
    function setAvatarURL($value) {
    	return $this->setFieldValue('avatar_url', $value);
    } // setAvatarURL
    
	/**
     * Return value of overview
     *
     * @param void
     * @return string
     */
    function getOverview() {
    	return $this->getFieldValue('overview');
    } // getOverview
    
    /**
     * Set value of overview
     *
     * @param string $value
     * @return string
     */
    function setOverview($value) {
    	return $this->setFieldValue('overview', $value);
    } // setOverview
    
	/**
     * Return value of default_visibility
     *
     * @param void
     * @return integer
     */
    function getDefaultVisibility() {
    	return $this->getFieldValue('default_visibility');
    } // getDefaultVisibility
    
    /**
     * Set value of default_visibility
     *
     * @param integer $value
     * @return integer
     */
    function setDefaultVisibility($value) {
    	return $this->setFieldValue('default_visibility', $value);
    } // setDefaultVisibility
    
	/**
     * Return value of starts_on
     *
     * @param void
     * @return date
     */
    function getStartsOn() {
    	return $this->getFieldValue('starts_on');
    } // getStartsOn
    
    /**
     * Set value of starts_on
     *
     * @param date $value
     * @return date
     */
    function setStartsOn($value) {
    	return $this->setFieldValue('starts_on', $value);
    } // setStartsOn
    
	/**
     * Return value of group_id
     *
     * @param void
     * @return integer
     */
    function getGroupId() {
    	return $this->getFieldValue('group_id');
    } // getGroupId
    
    /**
     * Set value of group_id
     *
     * @param integer $value
     * @return integer
     */
    function setGroupId($value) {
    	return $this->setFieldValue('group_id', $value);
    } // setGroupId
    
	/**
     * Return value of leader_id
     *
     * @param void
     * @return integer
     */
    function getLeaderId() {
    	return $this->getFieldValue('leader_id');
    } // getLeaderId
    
    /**
     * Set value of leader_id
     *
     * @param integer $value
     * @return integer
     */
    function setLeaderId($value) {
    	return $this->setFieldValue('leader_id', $value);
    } // setLeaderId
  
	/**
     * Return value of status
     *
     * @param void
     * @return string
     */
    function getStatus() {
    	return $this->getFieldValue('status');
    } // getStatus
    
    /**
     * Set value of status
     *
     * @param string $value
     * @return string
     */
    protected function setStatus($value) {
    	 return $this->setFieldValue('status', $value);
    } // setStatus
    
    /**
     * Return value of mime_type
     *
     * @param void
     * @return string
     */
    function getMimeType() {
    	return $this->getFieldValue('mime_type');
    } // getMimeType
    
    /**
     * Set value of mime_type
     *
     * @param string $value
     * @return string
     */
    protected function setMimeType($value) {
    	 return $this->setFieldValue('mime_type', $value);
    } // setMimeType
    
    /**
     * Return value of logo_url
     *
     * @param void
     * @return string
     */
    function getLogoUrl() {
    	return $this->getFieldValue('logo_url');
    } // getLogoUrl
    
    /**
     * Set value of logo_url
     *
     * @param string $value
     * @return string
     */
    protected function setLogoUrl($value) {
    	 return $this->setFieldValue('logo_url', $value);
    } // setLogoUrl
    
    /**
     * Return value of users
     *
     * @param void
     * @return string
     */
    function getCompanyUsers() {
    	return $this->getFieldValue('users');
    } // getUsers
    
    /**
     * Set value of users
     *
     * @param string $value
     * @return string
     */
    protected function setCompanyUsers($value) {
    	if(!empty($value)) {
    		$value =  ActiveCollab::makeArrayOfObject($value,'user');
    	}
    	return $this->setFieldValue('users', $value);
    } // setUsers
    
    /**
     * Return value of company
     *
     * @param void
     * @return string
     */
    function getCompany() {
    	return $this->getFieldValue('company');
    } // getCompany
    
    /**
     * Set value of company
     *
     * @param string $value
     * @return string
     */
    protected function setCompany($value) {
    	if(!empty($value)) {
    		$value =  ActiveCollab::makeArrayOfObject($value,'company');
    	}
    	return $this->setFieldValue('company', $value);
    } // setCompany
     
    /**
     * Return value of revisions
     *
     * @param void
     * @return string
     */
    function getRevisions() {
    	return $this->getFieldValue('revisions');
    } // getRevisions
    
    /**
     * Set value of revisions
     *
     * @param string $value
     * @return string
     */
    protected function setRevisions($value) {
    	if(!empty($value)) {
    		$value =  ActiveCollab::makeArrayOfObject($value,'revision',__CLASS__);
    	} // if
    	return $this->setFieldValue('revisions', $value);
    } // setRevisions

    /**
     * Return value of logged_user_permissions
     *
     * @param void
     * @return string
     */
    function getLogedUserPermision() {
    	return $this->getFieldValue('logged_user_permissions');
    } // getLogedUserPermision
    
    /**
     * Set value of logged_user_permissions
     *
     * @param string $value
     * @return string
     */
    protected function setLogedUserPermision($value) {
    	return $this->setFieldValue('logged_user_permissions', $value);
    } // setLogedUserPermision
	
    /**
     * Return value of icon_url
     *
     * @param void
     * @return string
     */
    function getIconUrl() {
    	return $this->getFieldValue('icon_url');
    } // getIconUrl
    
    /**
     * Set value of icon_url
     *
     * @param string $value
     * @return string
     */
    protected function setIconUrl($value) {
    	return $this->setFieldValue('icon_url', $value);
    } // setIconUrl
 	
    /**
     * Return value of permissions
     *
     * @param void
     * @return string
     */
    function getPermissions() {
    	return $this->getFieldValue('permissions');
    } // getPermissions
    
    /**
     * Set value of permissions
     *
     * @param string $value
     * @return string
     */
    protected function setPermissions($value) {
    	return $this->setFieldValue('permissions', $value);
    } // setPermissions
	
     /**
     * Return value of role
     *
     * @param void
     * @return string
     */
    function getRole() {
    	return $this->getFieldValue('role');
    } // getRole
    
    /**
     * Set value of role
     *
     * @param string $value
     * @return string
     */
    protected function setRole($value) {
    	return $this->setFieldValue('role', $value);
    } // setRole

    /**
     * Return value of projects
     *
     * @param void
     * @return string
     */
    function getProjects() {
    	return $this->getFieldValue('projects');
    } // getProjects
    
    /**
     * Set value of projects
     *
     * @param string $value
     * @return string
     */
    protected function setProjects($value) {
    	if(!empty($value)) {
    		$value =  ActiveCollab::makeArrayOfObject($value,'project');
    	} // if
    	return $this->setFieldValue('projects', $value);
    } // setProjects

    /**
     * Return value of revision_num
     *
     * @param void
     * @return string
     */
    function getRevisionNumber() {
    	return $this->getFieldValue('revision_num');
    } // getRevisionNumber
    
    /**
     * Set value of revision_num
     *
     * @param string $value
     * @return string
     */
    protected function setRevisionNumber($value) {
    	return $this->setFieldValue('revision_num', $value);
    } // setRevisionNumber
    
    /**
     * Return value of subpages
     *
     * @param void
     * @return string
     */
    function getSubPages() {
    	return $this->getFieldValue('subpages');
    } // getSubPages
    
    /**
     * Set value of subpages
     *
     * @param string $value
     * @return string
     */
    protected function setSubPages($value) {
    	if(!empty($value)) {
    		$value =  ActiveCollab::makeArrayOfObject($value,'subpage');
    	}
    	return $this->setFieldValue('subpages', $value);
    } // setSubPages
    
    /**
     * Return value of message
     *
     * @param void
     * @return string
     */
    function getMessage() {
    	return $this->getFieldValue('message');
    } // getMessage
    
    /**
     * Set value of message
     *
     * @param string $value
     * @return string
     */
    function setMessage($value) {
    	return $this->setFieldValue('message', $value);
    } // setMessage
       
    /**
     * Get assignees list
     * 
     * @param void
     * @return array
     */
    function getAssignees() {
    	return $this->assignee_list;
    } // getAssignees
    
    /**
     * Set assignees list
     * 
     * @param $value - array of user id
     * @param $responsible_person_id - responsible person id
     * @return false
     */
    function setAssignees($value,$responsible_person_id = false) {
    	if(!$responsible_person_id) { //if we read it from response
    		$assigneeList = $value;
	    	if(is_array($value['assignee'])) {
	    		foreach($value['assignee'] as $key => $item) {
	    			if((int)$item['is_owner'] == 1) {
	    				$this->assignee_responsible_id = $item['user_id'];
	    			} // if
	    		} // foreach
	    	} // if	
    	} else { //else we set it from outside
    		if($this->can_have_assignees) {
	    		if(is_array($value)) {
		    		if(in_array($responsible_person_id,$value)) {
		    			$this->addFieldToBeUpdated('assignees');
		    			$this->assignee_responsible_id = $responsible_person_id;
		    			$assigneeList = array($value,$responsible_person_id); 
		    		} else {
		    			throw new ActiveCollabCommonError(ERROR_ASSIGNEE_RESPONSABLE_PERSON);
		    		} // if
	    		} else {	//else $value isnt array
	    			throw new ActiveCollabCommonError(ERROR_ASSIGNEE_LIST);
	    		} // if
    		} else {
    			throw new ActiveCollabPermissionError($this->object_name,ERROR_PERMISSION_CREATE_ASSIGNEE);
    		} // if
    	} // if
    	$this->assignee_list = $assigneeList;
    } // setAssignees		
   	
   	/**
      * Return responsible person Id
      * 
      * @param void
      * @return integer
      */
     function getResponsiblePersonId() {
     	return $this->assignee_ResponsibleId;
     } // getResponsiblePersonId
     
     /**
      * Set created_by field
      * 
      * @param $value
      * @return false
      */
     protected function setCreatedBy($value) {
     	if(is_array($value)) {
     		$this->setCreatedById($value['id']);
     		$this->setCreatedByName($value['name']);
     	}
     }
   
}
?>