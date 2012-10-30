<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabFile class
 *
 */
class ActiveCollabFile extends ActiveCollabBaseObject {
	/**
	 * file id
	 * 
	 * @var integer
	 */
	protected $file_id = null;
	
	/**
	 * File we want to upload
	 * 
	 * @var array
	 */
	protected $file = false;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array();
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $file_id - file id
	 * @return object
	 */
	function __construct($project_id = false,$file_id = null) {
		$this->object_name = 'File';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->file_id = $file_id;
		if($file_id != null) {
			$file = $this->getFile();
			if($file) {
				$this->object_details = $file;
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
		
	} // setFlags
	
	/**
	 * Return file
	 * 
	 * @param void
	 * @return array
	 */
	private function getFile() {
		$pathInfo = '/projects/' . $this->project_id . '/files/'. $this->file_id;
		ActiveCollab::setRequestString($pathInfo);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // if
	
	/**
	 * Save file
	 * 
	 * @return mixed - file object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$pathInfo = $this->file_id == null ? '/projects/' . $this->project_id . '/files/upload-single' : '/projects/' . $this->project_id . '/files/' . $this->file_id . '/edit';
			ActiveCollab::setRequestString($pathInfo);
			$postParams = $this->setParams(ACTIVECOLLAB_PARAM_FILE_STRING); //create params [file]
			$fileParams[ACTIVECOLLAB_PARAM_FILE_STRING] = $this->file;
			$file = reset($fileParams);
			if($file || $postParams)
				$postParams['submitted'] = 'submitted';
			if($postParams || $file){
				$response = ActiveCollab::callAPI($postParams,$fileParams);
			} //if
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'file');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
	
	/**
	 * Set file for upload
	 * 
	 * @param $value
	 * @return array
	 */
	public function addFile($value) {
		$this->file = $value;
	} // addFile

}

?>