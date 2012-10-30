<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabChecklist class
 *
 */
class ActiveCollabChecklist extends ActiveCollabBaseObject {
	/**
	 * checklist id
	 * 
	 * @var integer
	 */
	protected $checklist_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $checklist_id - checklist id
	 * @return object
	 */
	function __construct($project_id = false,$checklist_id = null) {
		$this->object_name = 'Checklist';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->checklist_id = $checklist_id;
		if($checklist_id != null) {
			$checklist = $this->getChecklist();
			if($checklist) {
				$this->object_details = $checklist;
				$this->createObject();	
			} // if
		} // if
		return $this;
	}
	
	/**
	 * Set flags - set object action permissions
	 * 
	 * @return void
	 */
	private function setFlags() {
		$this->can_be_completed = true;
		$this->can_be_reopened = true;
		$this->can_be_subscribed = true;
		$this->can_be_unsubscribed = true;
		$this->can_have_subtasks = true;
	} // setFlags
	
	/**
	 * Return checklist
	 * 
	 * @param void
	 * @return array
	 */
	private function getChecklist() {
		$path_info = '/projects/' . $this->project_id . '/checklists/'. $this->checklist_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getChecklist
	
	/**
	 * Save checklist
	 * 
	 * @param void
	 * @return mixed - checklist object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->checklist_id == null ? '/projects/' . $this->project_id . '/checklists/add' : '/projects/' . $this->project_id . '/checklists/' . $this->checklist_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_CHECKLIST_STRING); //create params [checklist]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'checklist');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save

}

?>