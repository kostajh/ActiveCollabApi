<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabMilestone class
 *
 */
class ActiveCollabMilestone extends ActiveCollabBaseObject {
	/**
	 * milestone ID
	 * 
	 * @var integer
	 */
	protected $milestone_id = null;
		
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name','start_on','due_on');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $milestone_id - milestone id
	 * @return object
	 */
	function __construct($project_id = false,$milestone_id = null) {
		$this->object_name = 'Milestone';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->milestone_id = $milestone_id;
		if($milestone_id != null) {
			$milestone = $this->getMilestone();
			if($milestone) {
				$this->object_details = $milestone;
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
		$this->can_have_assignees = true;
		$this->can_have_subtasks = true;
	} // setFlags
	
	/**
	 * Return milestone
	 * 
	 * @return array
	 */
	private function getMilestone() {
		$path_info = '/projects/' . $this->project_id . '/milestones/'. $this->milestone_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getMilestone
	
	/**
	 * Save milestone
	 * 
	 * @param void
	 * @return mxed - milestone object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->milestone_id == null ? '/projects/' . $this->project_id . '/milestones/add' : '/projects/' . $this->project_id . '/milestones/' . $this->milestone_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_MILESTONE_STRING); //create params [milestone]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'milestone');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>