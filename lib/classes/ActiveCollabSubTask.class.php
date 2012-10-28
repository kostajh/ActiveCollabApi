<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabSubTask class
 *
 */
class ActiveCollabSubTask extends ActiveCollabBaseObject {
	/**
	 * subTaskID
	 * 
	 * @var integer
	 */
	protected $sub_task_id = null;
	
	/**
	 * Parent ID
	 * 
	 * @var integer
	 */
	protected $parent_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('body');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $sub_task_id - subtask id
	 * @return object
	 */
	function __construct($project_id = false,$sub_task_id = null) {
		$this->object_name = 'Subtask';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->sub_task_id = $sub_task_id;
		if($sub_task_id != null) {
			$subTask = $this->getSubTask();
			if($subTask) {
				$this->object_details = $subTask;
				$this->createObject();	
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
		$this->can_be_completed = true;
		$this->can_be_reopened = true;
		$this->can_be_subscribed = true;
		$this->can_be_unsubscribed = true;
		$this->can_have_assignees = true;
	} // setFlags
	
	/**
	 * Return subTask
	 * 
	 * @param void
	 * @return array
	 */
	private function getSubTask() {
		$pathInfo = '/projects/' . $this->project_id . '/tasks/'. $this->sub_task_id;
		ActiveCollab::setRequestString($pathInfo);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getSubTask
	
	/**
	 * Save subTask
	 * 
	 * @param void
	 * @return mixed - subTask object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			if($this->getParentId() == null && $this->sub_task_id == null) {
				throw new ActiveCollabInvalidParamError('Parent ID');
			} // if
			$this->parent_id = $this->getParentId();
			$path_info = $this->sub_task_id == null ? '/projects/' . $this->project_id . '/tasks/add&parent_id=' . $this->parent_id : '/projects/' . $this->project_id . '/tasks/' . $this->sub_task_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_SUBTASK_STRING); //create params [task]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'task');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>