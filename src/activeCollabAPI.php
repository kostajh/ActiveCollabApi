<?php

  /**
   * activeCollab API wrapper
   *
   * Copyright (C) 2010 A51 doo, Novi Sad, Serbia
   *
   * This library is free software; you can redistribute it and/or
   * modify it under the terms of the GNU Lesser General Public
   * License as published by the Free Software Foundation; either
   * version 2.1 of the License, or (at your option) any later version.
   *
   * This library is distributed in the hope that it will be useful,
   * but WITHOUT ANY WARRANTY; without even the implied warranty of
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
   * Lesser General Public License for more details.
   *
   * You should have received a copy of the GNU Lesser General Public
   * License along with this library; if not, write to the Free Software
   * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
   */

  // ---------------------------------------------------
  //  Constants
  // ---------------------------------------------------

  // Location of all wrapper files
  define('ACTIVECOLLAB_WRAPPER_PATH', dirname(__FILE__));

  // priority constants
  define('ACTIVECOLLAB_PRIORITY_LOWEST', -2);
  define('ACTIVECOLLAB_PRIORITY_LOW', -1);
  define('ACTIVECOLLAB_PRIORITY_NORMAL', 0);
  define('ACTIVECOLLAB_PRIORITY_HIGH', 1);
  define('ACTIVECOLLAB_PRIORITY_HIGHEST', 2);

  define('ACTIVECOLLAB_VISIBILITY_PRIVATE',0);
  define('ACTIVECOLLAB_VISIBILITY_NORMAL',1);

  define('ACTIVECOLLAB_PROJECT_STATUS_ACTIVE','active');
  define('ACTIVECOLLAB_PROJECT_STATUS_PAUSED','paused');
  define('ACTIVECOLLAB_PROJECT_STATUS_COMPLETED','completed');
  define('ACTIVECOLLAB_PROJECT_STATUS_CANCELED','canceled');

  define('ACTIVECOLLAB_PERMISSION_NO_ACCESS',0);
  define('ACTIVECOLLAB_PERMISSION_HAS_ACCESS',1);
  define('ACTIVECOLLAB_PERMISSION_CAN_CREATE',2);
  define('ACTIVECOLLAB_PERMISSION_CAN_MANAGE',3);

  define('ACTIVECOLLAB_BILLABLE_STATUS_NOT_BILLABLE',0);
  define('ACTIVECOLLAB_BILLABLE_STATUS_BILLABLE',1);
  define('ACTIVECOLLAB_BILLABLE_STATUS_BILLABLE_AND_PENDING',2);
  define('ACTIVECOLLAB_BILLABLE_STATUS_BILLED',3);

  // tags in ticket details for getComments,getSubTask...
  define('ACTIVECOLLAB_SUBTASKS_STRING','tasks');
  define('ACTIVECOLLAB_COMMENTS_STRING','comments');
  define('ACTIVECOLLAB_ATTACHMENTS_STRING','attachments');

  define('ACTIVECOLLAB_PARAM_TICKET_STRING','ticket');
  define('ACTIVECOLLAB_PARAM_SUBTASK_STRING','task');
  define('ACTIVECOLLAB_PARAM_COMMENT_STRING','comment');
  define('ACTIVECOLLAB_PARAM_ATTACHMENTS_STRING','attachment');
  define('ACTIVECOLLAB_PARAM_FILE_STRING','file');
  define('ACTIVECOLLAB_PARAM_DISCUSSION_STRING','discussion');
  define('ACTIVECOLLAB_PARAM_MILESTONE_STRING','milestone');
  define('ACTIVECOLLAB_PARAM_CHECKLIST_STRING','checklist');
  define('ACTIVECOLLAB_PARAM_PAGE_STRING','page');
  define('ACTIVECOLLAB_PARAM_TIME_STRING','time');
  define('ACTIVECOLLAB_PARAM_COMPANY_STRING','company');
  define('ACTIVECOLLAB_PARAM_USER_STRING','user');
  define('ACTIVECOLLAB_PARAM_PROJECT_STRING','project');
  define('ACTIVECOLLAB_PARAM_GROUP_STRING','project_group');
  define('ACTIVECOLLAB_PARAM_STATUS_STRING','status');

  // ---------------------------------------------------
  //  Functions
  // ---------------------------------------------------

  /**
   * Cast row data to date value (object of DateValue class)
   *
   * @param mixed $value
   * @return DateValue
   */
  function dateval($value) {
    if(empty($value)) {
      return null;
    } // if

    if($value instanceof DateValue) {
      return $value;
    } elseif(is_int($value) || is_string($value)) {
      return new DateValue($value);
    } else {
      return null;
    } // if
  } // dateval

  /**
   * Cast raw datetime format (string) to DateTimeValue object
   *
   * @param string $value
   * @return DateTimeValue
   */
  function datetimeval($value) {
    if(empty($value)) {
      return null;
    } // if

    if($value instanceof DateTimeValue) {
      return $value;
    } elseif($value instanceof DateValue) {
      return new DateTimeValue($value->toMySQL());
    } elseif(is_int($value) || is_string($value)) {
      return new DateTimeValue($value);
    } else {
      return null;
    } // if
  } // datetimeval

  /**
   * Cast raw value to boolean value
   *
   * @param mixed $value
   * @return boolean
   */
  function boolval($value) {
    return (boolean) $value;
  } // boolval

  // ---------------------------------------------------
  //  Include files
  // ---------------------------------------------------

  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/errors/ActiveCollabInvalidParamError.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/errors/ActiveCollabCommonError.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/errors/ActiveCollabCommandNotRecognized.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/errors/ActiveCollabPermissionError.class.php';

  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/DateValue.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/DateTimeValue.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/Snoopy.class.php';

  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollab.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabBaseObject.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabAttachment.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabCategory.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabChecklist.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabComment.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabCompany.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabDiscussion.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabFile.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabMilestone.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabPage.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabProject.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabProjectGroup.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabRole.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabStatusMessage.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabSubTask.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabTicket.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabTime.class.php';
  require_once ACTIVECOLLAB_WRAPPER_PATH . '/classes/ActiveCollabUser.class.php';

?>
