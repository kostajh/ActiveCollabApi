<?php
include_once('ActiveCollabBaseObject.class.php');
/**
 * ActiveCollabAttachment class
 *
 */
class ActiveCollabAttachment extends ActiveCollabBaseObject {
	/**
	 * Construct the object
	 * 
	 * @param void
	 * @return object
	 */
	function __construct() {
		$this->object_name = 'Attachment';
		return $this;
	} // construct
}

?>