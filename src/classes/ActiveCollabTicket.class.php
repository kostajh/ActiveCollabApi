<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabTicket class
 *
 */
class ActiveCollabTicket extends ActiveCollabBaseObject {
	/**
	 * ticketID
	 *
	 * @var integer
	 */
	protected $ticket_id = null;

	/**
	 * Fields to be changed in original geter fields
	 * If field doesnt exist use name of get function as value ie. integer_field_3 => 'getTicketID'
	 *
	 * @var array
	 */
	protected $maped_fields = array('integer_field_1' => 'ticket_id');

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
	 * @param $ticket_id - ticket id
	 * @return object
	 */
	function __construct($project_id = false,$ticket_id = null) {
		$this->object_name = 'Ticket';
		$this->setFlags();
		//change mapped var in geter
		$this->changeMapedFields();
		if($project_id) {
			$this->project_id = $project_id;
			$this->ticket_id = $ticket_id;
			if($ticket_id) {
				$ticket = $this->getTicket();
				if($ticket) {
					$this->object_details = $ticket; //object_details is array
					$this->createObject();  //fill this object with values from returned array
				} // if
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
		$this->can_have_subtasks = true;
		$this->can_have_comments = true;
		$this->can_have_attachments = true;
	} // setFlags

	/**
	 * Return ticket
	 *
	 * @param void
	 * @return array
	 */
	private function getTicket() {
		$path_info = '/projects/' . $this->project_id . '/tickets/'. $this->ticket_id;
		ActiveCollab::setRequestString($path_info);
		$response = ActiveCollab::callAPI();
		if (is_array($response)) {
			return $response;
		} // if
	} // getTicket

	/**
	 * Save ticket
	 *
	 * @param void
	 * @return mixed - ticket object on success, and false on fail.
	 */
	public function save() {
		if(!$this->validateSave()) {
			$path_info = $this->ticket_id == null ? '/projects/' . $this->project_id . '/tickets/add' : '/projects/' . $this->project_id . '/tickets/' . $this->ticket_id . '/edit';
			ActiveCollab::setRequestString($path_info); //format API url with given path info
			$post_params = $this->setParams(ACTIVECOLLAB_PARAM_TICKET_STRING); //create params [ticket]
			$file_params = $this->attachments;
			if($post_params || $file_params)
				$response = ActiveCollab::callAPI($post_params,$file_params);
			if($response) {
				$response = ActiveCollab::convertXMLToArray($response,'ticket');
				return $response;
			} // if
			return false;
		} else {
			throw new ActiveCollabInvalidParamError($this->validateSave());
		} // if
	} // save

}
?>
