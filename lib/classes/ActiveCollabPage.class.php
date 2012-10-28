<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabPage class
 * 
 */
class ActiveCollabPage extends ActiveCollabBaseObject {
	/**
	 * page ID
	 * 
	 * @var integer
	 */
	protected $page_id = null;

	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name','body','parent_id');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $page_id - page id
	 * @return object
	 */
	function __construct($project_id = false,$page_id = null) {
		$this->object_name = 'Page';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->page_id = $page_id;
		if($page_id != null) {
			$page = $this->getPage();
			if($page) {
				$this->object_details = $page;
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
		$this->can_be_subscribed = true;
		$this->can_be_unsubscribed = true;
		$this->can_have_comments = true;
		$this->can_have_subtasks = true;
		$this->can_have_attachments = true;
	} // setFlags
	
	/**
	 * Return checklist
	 * 
	 * @param void
	 * @return array
	 */
	private function getPage() {
		$path_info = '/projects/' . $this->project_id . '/pages/'. $this->page_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getPage
	
	/**
	 * Save checklist
	 * 
	 * @param void
	 * @return mixed - checklist object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->page_id == null ? '/projects/' . $this->project_id . '/pages/add' : '/projects/' . $this->project_id . '/pages/' . $this->page_id . '/edit';
			ActiveCollab::setRequestString($path_info);
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_PAGE_STRING); //create params [page]
			$file_params = $this->attachments;
			if($post_params)
				$response = ActiveCollab::callAPI($post_params,$file_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'category');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>