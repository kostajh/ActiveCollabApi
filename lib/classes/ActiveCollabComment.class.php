<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabComment class
 *
 */
class ActiveCollabComment extends ActiveCollabBaseObject {
	/**
	 * comment id
	 * 
	 * @var integer
	 */
	protected $comment_id = null;
	
	/**
	 * Parent id
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
	 * @param $comment_id - comment id
	 * @return object
	 */
	function __construct($project_id = false,$comment_id = null) {
		$this->object_name = 'Comment';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->comment_id = $comment_id;
		if($comment_id != null) {
			$comment = $this->getComment();
			if($comment) {
				$this->object_details = $comment;
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
		$this->can_have_attachments = true;
	} // setFlags
	
	/**
	 * Return comment
	 * 
	 * @param void
	 * @return array
	 */
	private function getComment() {
		$path_info = '/projects/' . $this->project_id . '/comments/'. $this->comment_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getComment
	
	/**
	 * Save comment
	 * 
	 * @param void
	 * @return mixed - comment object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			if($this->getParentId() == null && $this->comment_id == null) {
				throw new ActiveCollabInvalidParamError('Parent ID');
			} // if
			$this->parent_id = $this->getParentId();		
			$path_info = $this->comment_id == null ? '/projects/' . $this->project_id . '/comments/add&parent_id=' . $this->parent_id : '/projects/' . $this->project_id . '/comments/' . $this->comment_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_COMMENT_STRING); //create params [comment]
			$file_params = $this->attachments;
			if($post_params || $file_params)
				$response = ActiveCollab::callAPI($post_params,$file_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'comment');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>