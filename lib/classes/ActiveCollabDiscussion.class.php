<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabDiscussion class
 *
 */
class ActiveCollabDiscussion extends ActiveCollabBaseObject {
	/**
	 * discussion ID
	 * 
	 * @var integer
	 */
	protected $discussion_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name','body');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $discussion_id - discussion id
	 * @return object
	 */
	function __construct($project_id = false,$discussion_id = null) {
		$this->object_name = 'Discussion';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->discussion_id = $discussion_id;
		if($discussion_id != null) {
			$discussion = $this->getDiscussion();
			if($discussion) {
				$this->object_details = $discussion;
				$this->createObject();	
			} //if
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
		$this->can_have_attachments = true;
		$this->can_have_comments = true;
		$this->can_be_subscribed = true;
		$this->can_be_unsubscribed = true;
		$this->can_have_assignees = true;
	} // setFlags
	
	/**
	 * Return discussion
	 * 
	 * @param void
	 * @return array
	 */
	private function getDiscussion() {
		$path_info = '/projects/' . $this->project_id . '/discussions/'. $this->discussion_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getDiscussion
	
	/**
	 * Save comment
	 * 
	 * @param void
	 * @return mixed - comment object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->discussion_id == null ? '/projects/' . $this->project_id . '/discussions/add' : '/projects/' . $this->project_id . '/discussions/' . $this->discussion_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_DISCUSSION_STRING); //create params [discussion]
			$file_params = $this->attachments;
			if($post_params)
				$response = ActiveCollab::callAPI($post_params,$file_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'discussion');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>