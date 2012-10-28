<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabTime class
 *
 */
class ActiveCollabTime extends ActiveCollabBaseObject {
	/**
	 * timeID
	 * 
	 * @var integer
	 */
	protected $time_id = null;
	
	/**
	 * Fields mandatory for save action
	 * 
	 * @var array
	 */
	protected $mandatory_fields = array('user_id','value','record_date');
	
	/**
	 * Construct the object
	 * 
	 * @param $project_id - project id
	 * @param $time_id - time id
	 * @return object
	 */
	function __construct($project_id = false,$time_id = null) {
		$this->object_name = 'Time';
		$this->setFlags();
		$this->project_id = $project_id;
		$this->time_id = $time_id;
		if($time_id) {
			$time = $this->getTime();
			if($time) {
				$this->object_details = $time; //timeDetails is array 
				if($time['user']['id']) {
					$this->setUserID($time['user']['id']);
				} // if
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
		
	} // setFlags
	
	/**
	 * Return time 
	 * 
	 * @param void
	 * @return array
	 */
	private function getTime() {
		$path_info = '/projects/' . $this->project_id . '/time/'. $this->time_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI(); 
		if($response) {
			return ActiveCollab::convertXMLToArray($response);
		} // if
	} // getTime
	
	/**
	 * Save time
	 * 
	 * @param void
	 * @return mixed - time record object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->time_id == null ? '/projects/' . $this->project_id . '/time/add' : '/projects/' . $this->project_id . '/time/' . $this->time_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_TIME_STRING); //create params [time]
			if($post_params)
				$response = ActiveCollab::callAPI($post_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'time_record');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save
}

?>