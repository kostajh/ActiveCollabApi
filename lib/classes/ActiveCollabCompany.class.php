<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabCompany class
 *
 */
class ActiveCollabCompany extends ActiveCollabBaseObject {
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('name');
	
	/**
	 * Construct the object
	 * 
	 * @param $company_id - company id
	 * @return object
	 */
	function __construct($company_id = null) {
		$this->object_name = 'Company';
		$this->setFlags();
		$this->company_id = $company_id;
		if($company_id) {
			$company = $this->getCompanyById();
			if($company) {
				$this->object_details = $company; //companyDetails is array 
				$this->createObject();  //fill this object with values from returned array	
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
		$this->can_have_users = true;
	} // setFlags
	
	/**
	 * Return company 
	 * 
	 * @param void
	 * @return array
	 */
	private function getCompanyById() {
		$path_info = '/people/' . $this->company_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getCompany
	
	/**
	 * Save company
	 * 
	 * @param void
	 * @return mixed - company object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->company_id == null ? '/people/add-company' : '/people/' . $this->company_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_COMPANY_STRING); //create params [company]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'company');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
		
	/**
	 * Delete company
	 * 
	 * @return boolean - false on failure, true on success
	 */
	public function delete() {
		$path_info = '/people/' . $this->company_id . '/delete';
		ActiveCollab::setRequestString($path_info); //format API url with given path info
		$param = $this->createParamsForCommonOp();
		$response = ActiveCollab::callAPI($param);
		if(empty($response)){
			return true;
		} // if
		return $response;
	} // delete
}

?>