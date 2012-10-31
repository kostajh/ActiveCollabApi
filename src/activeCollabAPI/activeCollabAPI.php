<?php

namespace activeCollabAPI;

/**
 * ActiveCollab class
 *
 */
class activeCollabAPI {

  /**
   * Key for authorization
   *
   * @var string
   */
  protected static $key = null;

  /**
   * API URL
   *
   * @var string
   */
  protected static $api_url = null;

  /**
   * API url
   *
   * @var string
   */
  protected static $api_string = null;

  /**
   * API response
   *
   * @var string
   */
  protected static $API_response = null;

  /**
   * Format request string
   *
   * @param $path_info - requested path
   * @param $additional_params - additional params
   * @return string
   */
  public static function setRequestString($path_info,$additional_params = null) {
    if (self::$key != null && $path_info != null) {
      self::$api_string = self::$api_url . "?path_info=" . $path_info;
    }
    if(is_array($additional_params) && !empty($additional_params))  {
      foreach ($additional_params as $name => $value) {
        self::$api_string .= "&" . $name . "=" . $value;
      }
    }
    // Set the token.
    self::$api_string .= "&token=" . self::$key;
    // Set format to JSON.
    self::$api_string .= "&format=json";
    return self::$api_string;
  }

  /**
   * Set key for authorisation
   *
   * @param integer $key
   * @return string
   */
  public static function setKey($key) {
    if($key != null)
      return self::$key = $key;
  }

  /**
   * Set API url
   *
   * @param string $value
   * @return string
   */
  public static function setAPIUrl($value) {
    return self::$api_url = $value;
  }

  /**
   * Make API call
   *
   * @param array $post_params
   * @param array $file_params
   * @return object
   */
  public static function callAPI($post_params = false, $file_params = false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::$api_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $message = curl_exec($ch);
    if ($message == 'HTTP/1.1 404 Not Found' || $message == '<h1>HTTP/1.1 403 Forbidden</h1>') {
      throw new ActiveCollabCommonError(ERROR_API_RESPONSE . ' ' . $message);
    }
    $response = json_decode($message);
    curl_close($ch);
    if (!self::checkResponse($response)) {
      // Throw an error.
      throw new ActiveCollabCommonError(ERROR_API_RESPONSE . ' ' . self::$API_response);
    } else {
      return $response;
    }
  }

  /**
   * Return API version
   *
   * @param void
   * @return array
   */
  public function getVersion() {
    self::setRequestString('info');
    return self::callAPI();
  }

  /**
   * List all project
   *
   * @param void
   * @return array - array of ActiveCollabProject objects
   */
  public function listProjects() {
    $path_info = '/projects';
    self::setRequestString($path_info);
    return self::callAPI();
  }

  /**
   * Helper function to check if the response is an object or array.
   */
  private function checkResponse($response) {
    return (is_array($response) || is_object($response)) ? $response : FALSE;
  }

  /**
   * List all people involved with a project and their permissions.
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabUser objects
   */
  public function listPeopleByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/people';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * Get API version
   *
   * @return float
   */
  protected function getAPIVersion() {
    $api_version = self::getVersion();
    return $api_version['api_version'];
  }

  /**
   * List all categories
   *
   * @param $project_id - Project id
   * @param $object - Object name
   * @return array of ActiveCollabCategory object`s
   */
  protected function listCategories($project_id,$object_name) {
    if(self::getAPIVersion() > 2.0) {
      $path_info = 'projects/' . $project_id . '/' . $object_name . '/categories';
      self::setRequestString($path_info);
      $response = self::callAPI();
      if (is_array($response)) {
        return $response;
      }
    } else {
      throw new ActiveCollabCommandNotRecognized(COMMAND_NOT_RECOGNIZED . 'Your API version is ' . self::getAPIVersion());
    }
  }

  /**
   * List ticket categories
   *
   * @param $project_id
   * @return array
   */
  public function listTicketCategoriesByProjectId($project_id) {
    return self::listCategories($project_id,'tickets');
  }

  /**
   * List discussion categories
   *
   * @param $project_id
   * @return array
   */
  public function listDiscussionCategoriesByProjectId($project_id) {
    return self::listCategories($project_id,'discussions');
  }

  /**
   * List file categories
   *
   * @param $project_id
   * @return array
   */
  public function listFileCategoriesByProjectId($project_id) {
    return self::listCategories($project_id,'files');
  }

  /**
   * List page categories
   *
   * @param $project_id
   * @return array
   */
  public function listPageCategoriesByProjectId($project_id) {
    return self::listCategories($project_id,'pages');
  }

  /**
   * List all available project groups.
   *
   * @param void
   * @return array - array of ActiveCollabProjectGroup objects
   */
  public function listProjectGroups() {
    $path_info = 'projects/groups';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all ticket for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabTicket objects
   */
  public function listTicketsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/tickets';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all ticket for specific project and category
   *
   * @param $project_id - Project id
   * @param $category_id - Category id
   * @return array - array of ActiveCollabTicket objects
   */
  public function listTicketsByCategoryId($project_id,$category_id) {
    if(self::getAPIVersion() > 2.0) {
      $additional_param = array('category_id' => $category_id);
      $path_info = '/projects/' . $project_id . '/tickets';
      self::setRequestString($path_info,$additional_param);
      $response = self::callAPI();
      if (is_array($response)) {
        return $response;
      }
    } else {
      throw new ActiveCollabCommandNotRecognized(COMMAND_NOT_RECOGNIZED . 'Your API version is ' . self::getAPIVersion());
    } // if
  } // listTicketsByCategoryId

  /**
   * List all archived ticket for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabTicket objects
   */
  public function listArchivedTicketsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/tickets/archive';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all files for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabFile objects
   */
  public function listFilesByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/files';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  } // listFilesByProjectId

  /**
   * List all files for specific project and category
   *
   * @param $project_id - Project id
   * @param $category_id - Category id
   * @return array - array of ActiveCollabFile objects
   */
  public function listFilesByCategoryId($project_id,$category_id) {
    if(self::getAPIVersion() > 2.0) {
      $additional_param = array('category_id' => $category_id);
      $path_info = '/projects/' . $project_id . '/files';
      self::setRequestString($path_info,$additional_param);
      $response = self::callAPI();
      if (is_array($response)) {
        return $response;
      }
    } else {
      throw new ActiveCollabCommandNotRecognized(COMMAND_NOT_RECOGNIZED . 'Your API version is ' . self::getAPIVersion());
    } // if
  } // listFilesByCategoryId

  /**
   * List all discussions for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabDiscussion objects
   */
  public function listDiscussionsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/discussions';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  } // listDiscussionsByProjectId

  /**
   * List all discussion for specific project and category
   *
   * @param $project_id - Project id
   * @param $category_id - Category id
   * @return array - array of ActiveCollabDiscussion objects
   */
  public function listDiscussionsByCategoryId($project_id,$category_id) {
    if(self::getAPIVersion() > 2.0) {
      $additional_param = array('category_id' => $category_id);
      $path_info = '/projects/' . $project_id . '/discussions';
      self::setRequestString($path_info,$additional_param);
      $response = self::callAPI();
      if (is_array($response)) {
        return $response;
      }
    } else {
      throw new ActiveCollabCommandNotRecognized(COMMAND_NOT_RECOGNIZED . 'Your API version is ' . self::getAPIVersion());
    } // if
  } // listDiscussionsByCategoryId

  /**
   * List all milestones for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabMilestone objects
   */
  public function listMilestonesByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/milestones';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all checklists for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabChecklist objects
   */
  public function listChecklistsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/checklists';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all arhived checklist for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabChecklist object
   */
  public function listArchivedChecklistsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/checklists/archive';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all page for specific project and category
   *
   * @param $project_id - Project id
   * @param $category_id - Category id
   * @return array - array of ActiveCollabPage objects
   */
  public function listPagesByCategoryId($project_id,$category_id) {
    if(self::getAPIVersion() > 2.0) {
      $additional_param = array('category_id' => $category_id);
      $path_info = '/projects/' . $project_id . '/pages';
      self::setRequestString($path_info,$additional_param);
      $response = self::callAPI();
      if (is_array($response)) {
        return $response;
      }
    } else {
      throw new ActiveCollabCommandNotRecognized(COMMAND_NOT_RECOGNIZED . 'Your API version is ' . self::getAPIVersion());
    } // if
  } // listPageByCategoryId

  /**
   * List all time records for specific project
   *
   * @param $project_id - project Id
   * @return array - array of ActiveCollabTime objects
   */
  public function listTimeRecordsByProjectId($project_id) {
    $path_info = '/projects/' . $project_id . '/time';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all system roles
   *
   * @param void
   * @return array - array of ActiveCollabRole objects
   */
  public function listSystemRoles() {
    $path_info = '/roles/system';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all project roles
   *
   * @param void
   * @return array - array of ActiveCollabRole objects
   */
  public function listProjectRoles() {
    $path_info = '/roles/project';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List role details
   *
   * @param $role_id - role id
   * @return object - ActiveCollabRole object
   */
  public function findRoleDetailsById($role_id) {
    $path_info = '/roles/' . $role_id;
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all companies
   *
   * @param $void
   * @return array - array of ActiveCollabCompany objects
   */
  public function listCompanies() {
    $path_info = '/people';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all status message
   *
   * @param $void
   * @return array - array of ActiveCollabStatusMessage objects
   */
  public function listStatusMessages() {
    $path_info = '/status';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * List all status message created by user
   *
   * @param $user_id - user id
   * @return array - array of ActiveCollabStatusMessage objects
   */
  public function listStatusMessagesByUserId($user_id) {
    $path_info = '/status';
    $additional_params = array('user_id' => $user_id);
    self::setRequestString($path_info,$additional_params);
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    }
  }

  /**
   * Create ActiveCollabTicket object
   *
   * @param $project_id - project id
   * @param $id - ticket id
   * @return object
   */
  public function findTicketById($project_id,$id) {
    return new ActiveCollabTicket($project_id, $id);
  } // findTicketById

  /**
   * Create ActiveCollabSubTask object
   *
   * @param $project_id - project id
   * @param $id - subtask id
   * @return object
   */
  public function findSubTaskById($project_id,$id) {
    return new ActiveCollabSubTask($project_id, $id);
  } // findSubTaskById

  /**
   * Create ActiveCollabComment object
   *
   * @param $project_id - project id
   * @param $id - comment id
   * @return object
   */
  public function findCommentById($project_id,$id) {
    return new ActiveCollabComment($project_id, $id);
  } // findCommentById

  /**
   * Create ActiveCollabFile object
   *
   * @param $project_id - project id
   * @param $id - file id
   * @return object
   */
  public function findFileById($project_id,$id) {
    return new ActiveCollabFile($project_id, $id);
  } // findFileById

  /**
   * Create ActiveCollabDiscussion object
   *
   * @param $project_id - project id
   * @param $id - discussion id
   * @return object
   */
  public function findDiscussionById($project_id,$id) {
    return new ActiveCollabDiscussion($project_id, $id);
  } // findDiscussionById

  /**
   * Create ActiveCollabMilestone object
   *
   * @param $project_id - project id
   * @param $id - milestone id
   * @return object
   */
  public function findMilestoneById($project_id,$id) {
    return new ActiveCollabMilestone($project_id, $id);
  } // findMilestoneById

  /**
   * Create ActiveCollabProjectGroup object
   *
   * @param $id - project group id
   * @return object
   */
  public function findProjectGroupById($id) {
    return new ActiveCollabProjectGroup($id);
  } // findGroupById

  /**
   * Create ActiveCollabChecklist object
   *
   * @param $project_id - project id
   * @param $id - checklist id
   * @return object
   */
  public function findChecklistById($project_id,$id) {
    return new ActiveCollabChecklist($project_id, $id);
  } // findChecklistById

  /**
   * Create ActiveCollabPage object
   *
   * @param $project_id - project id
   * @param $id - page id
   * @return object
   */
  public function findPageById($project_id,$id) {
    return new ActiveCollabPage($project_id, $id);
  } // findPageById

  /**
   * Create ActiveCollabTime object
   *
   * @param $project_id - project id
   * @param $id - time record id
   * @return object
   */
  public function findTimeById($project_id,$id) {
    return new ActiveCollabTime($project_id, $id);
  } // findTimeById

  /**
   * Create ActiveCollabCompany object
   *
   * @param $id - company id
   * @return object
   */
  public function findCompanyById($id) {
    return new ActiveCollabCompany($id);
  } // findCompanyById

  /**
   * Create ActiveCollabUser object
   *
   * @param $company_id - company id
   * @param $id - user id
   * @return object
   */
  public function findUserById($company_id,$id) {
    return new ActiveCollabUser($company_id, $id);
  } // findUserById

  /**
   * Create ActiveCollabProject object
   *
   * @param $id - project id
   * @return object
   */
  public function findProjectById($id) {
    return new ActiveCollabProject($id);
  } // findProjectById


}
?>

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
