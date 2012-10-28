<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabCategories class
 *
 */
class ActiveCollabCategory extends ActiveCollabBaseObject {
	/**
	 * category id
	 * 
	 * @var integer
	 */
	protected $category_id = null;
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $category_id - category id
	 * @return object
	 */
	function __construct($project_id = false,$category_id = null) {
		$this->object_name = 'Category';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->category_id = $category_id;
		if($category_id != null) {
			$category = $this->getCategory();
			if($category) {
				$this->object_details = $category;
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
	} // setFlags
	
	/**
	 * Return category
	 * 
	 * @param void
	 * @return array
	 */
	private function getCategory() {
		$path_info = '/projects/' . $this->project_id . '/category/'. $this->category_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getCategory
	
	/**
	 * Save category
	 * 
	 * @param void
	 * @return mixed - category object on success, and false on fail.
	 */
//	public function save() {
//		if(!$this->validateSave()) {
//			$path_info = $this->checklist_id == null ? '/projects/' . $this->project_id . '/checklists/add' : '/projects/' . $this->project_id . '/checklists/' . $this->checklist_id . '/edit';
//			ActiveCollab::setRequestString($path_info);
//			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_CHECKLIST_STRING); //create params [checklist]
//			if($post_params)
//				$response = ActiveCollab::callAPI($post_params);
//			if($response) {
//				$response = ActiveCollab::convertXMLToArray($response,'checklist');
//				return $response;
//			} // if
//			return false;
//		} else {
//			throw new ActiveCollabInvalidParamError($this->validateSave());
//		} // if
//	} // save
	
}

?>