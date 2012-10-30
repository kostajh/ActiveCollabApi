<?php
/**
 * ActiveCollab class
 *
 */
class ActiveCollab {

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
   * Mapped class name with first tag from response
   *
   * @var array
   */
  private static $class_name = array(
    'ticket' => 'ActiveCollabTicket',
    'project_group' => 'ActiveCollabProjectGroup',
    'system_role' => 'ActiveCollabRole',
    'project_role' => 'ActiveCollabRole',
    'company' => 'ActiveCollabCompany',
    'project_user' => 'ActiveCollabUser',
    'file' => 'ActiveCollabFile',
    'discussion' => 'ActiveCollabDiscussion',
    'milestone' => 'ActiveCollabMilestone',
    'checklist' => 'ActiveCollabChecklist',
    'category' => 'ActiveCollabPage',
    'time_record' => 'ActiveCollabTime',
    'comment' => 'ActiveCollabComment',
    'task' => 'ActiveCollabSubTask',
    'attachment' => 'ActiveCollabAttachment',
    'assignment' => 'ActiveCollabTicket',
    'project' => 'ActiveCollabProject',
    'user' => 'ActiveCollabUser',
    'assignment' => 'ActiveCollabTicket',
    'subpage' => 'ActiveCollabPage',
    'message' => 'ActiveCollabStatusMessage',
    'categories' => 'ActiveCollabCategory',
    'page' => 'ActiveCollabPage'
  );

  /**
   * Error codes from API
   *
   * @var array
   */
  private static $API_error_codes = array(
    100 => "HTTP/1.1 100 Continue",
    101 => "HTTP/1.1 101 Switching Protocols",
    200 => "HTTP/1.1 200 OK",
    201 => "HTTP/1.1 201 Created",
    202 => "HTTP/1.1 202 Accepted",
    203 => "HTTP/1.1 203 Non-Authoritative Information",
    204 => "HTTP/1.1 204 No Content",
    205 => "HTTP/1.1 205 Reset Content",
    206 => "HTTP/1.1 206 Partial Content",
    300 => "HTTP/1.1 300 Multiple Choices",
    301 => "HTTP/1.1 301 Moved Permanently",
    302 => "HTTP/1.1 302 Found",
    303 => "HTTP/1.1 303 See Other",
    304 => "HTTP/1.1 304 Not Modified",
    305 => "HTTP/1.1 305 Use Proxy",
    307 => "HTTP/1.1 307 Temporary Redirect",
    400 => "HTTP/1.1 400 Bad Request",
    401 => "HTTP/1.1 401 Unauthorized",
    402 => "HTTP/1.1 402 Payment Required",
    403 => "HTTP/1.1 403 Forbidden",
    404 => "HTTP/1.1 404 Not Found",
    405 => "HTTP/1.1 405 Method Not Allowed",
    406 => "HTTP/1.1 406 Not Acceptable",
    407 => "HTTP/1.1 407 Proxy Authentication Required",
    408 => "HTTP/1.1 408 Request Time-out",
    409 => "HTTP/1.1 409 Conflict",
    410 => "HTTP/1.1 410 Gone",
    411 => "HTTP/1.1 411 Length Required",
    412 => "HTTP/1.1 412 Precondition Failed",
    413 => "HTTP/1.1 413 Request Entity Too Large",
    414 => "HTTP/1.1 414 Request-URI Too Large",
    415 => "HTTP/1.1 415 Unsupported Media Type",
    416 => "HTTP/1.1 416 Requested range not satisfiable",
    417 => "HTTP/1.1 417 Expectation Failed",
    500 => "HTTP/1.1 500 Internal Server Error",
    501 => "HTTP/1.1 501 Not Implemented",
    502 => "HTTP/1.1 502 Bad Gateway",
    503 => "HTTP/1.1 503 Service Unavailable",
    504 => "HTTP/1.1 504 Gateway Time-out"
  );

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
    } // if
    if(is_array($additional_params) && !empty($additional_params))  {
      foreach ($additional_params as $name => $value) {
        self::$api_string .= "&" . $name . "=" . $value;
      } // foreach
    } // if
    self::$api_string .= "&token=" . self::$key;
    // Set format to JSON.
    self::$api_string .= "&format=json";
    return self::$api_string;
  } // setRequestString

  /**
   * Set key for authorisation
   *
   * @param integer $key
   * @return string
   */
  public static function setKey($key) {
    if($key != null)
      return self::$key = $key;
  } // setKey

  /**
   * Set API url
   *
   * @param string $value
   * @return string
   */
  public static function setAPIUrl($value) {
    return self::$api_url = $value;
  } // setAPIUrl

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
    if (!is_array($response) && !is_object($response)) {
      // throw an error
      throw new ActiveCollabCommonError(ERROR_API_RESPONSE . ' ' . self::$API_response);
    } else {
      return $response;
    }
  } // callAPI

  /**
   * Check if array is multidimensional
   *
   * @param $array - array to check
   * @return boolean - true if array is multidimensional, false if not
   */
  public function isMultidimensionalArray($array) {
     if (is_array(@reset($array)))
      return true;
     else
       return false;
  } //isMultidimensionalArray

  /**
   * Convert response from API to array or object
   *
   * @param $xml - XML response from API
   * @param $object - object name
   * @return mixed
   */
    public function convertXMLToArray($xml,$object = false,$class_name = false) {
      $obj = new SimpleXMLElement($xml);
      $response = array();
      self::convertXmlObjToArr($obj,$response);
      if(!$object) {
        return $response;
      } else {
        if(!empty($response)){
          $tmp = self::makeArrayOfObject($response,$object,$class_name);
          return $tmp;
        } // if
      } // if
    } // convertXMLToArray

    /**
     * Create array of object
     *
     * @param $response - array
     * @param $object_name - first key of array
     * @param $make_base_class - name of class
     * @return mixed
     */
    public static function makeArrayOfObject($response,$object_name,$make_base_class = false) {
      if(!$make_base_class)
        $class_name = self::$class_name[$object_name];
      else
        $class_name = $make_base_class;
      if(self::isMultidimensionalArray($response)){
        if(self::isMultidimensionalArray($response[$object_name])) {
          foreach($response[$object_name] as $key => $value) {
            $newObj = new $class_name();
              $newObj->setObjectValues($value);
              $tmp[] = $newObj;
            } // foreach
        } else {
          $newObj = new $class_name();
          $newObj->setObjectValues($response[$object_name]);
            $tmp[] = $newObj;
        } // if
      } else {
        $newObj = new $class_name();
        $newObj->setObjectValues($response);
        $tmp = $newObj;
      }
      return $tmp;
    }

  /**
     * Parse a SimpleXMLElement object recursively into an Array.
     *
     * @param $xml - The SimpleXMLElement object
     * @param $arr - Target array where the values will be stored
     * @return null
     */
    private function convertXmlObjToArr($obj,&$arr) {
        $children = $obj->children();
        $executed = false;
        $arr = array();
        foreach ($children as $elementName => $node) {
          if( array_key_exists( $elementName , $arr )) {
            if(is_array($arr[$elementName]) && array_key_exists( 0 ,$arr[$elementName])){
                    $i = count($arr[$elementName]);
                    self::convertXmlObjToArr ($node, $arr[$elementName][$i]);
                } else {
                    $tmp = $arr[$elementName];
                    $arr[$elementName] = array();
                    $arr[$elementName][0] = $tmp;
                    $i = count($arr[$elementName]);
                    self::convertXmlObjToArr($node, $arr[$elementName][$i]);
               } // if
            } else {
                $arr[$elementName] = array();
                self::convertXmlObjToArr($node, $arr[$elementName]);
            } // if
            $executed = true;
        } // foreach
        if(!$executed && $children->getName() == "") {
            $arr = (String)$obj;
        } // if
       return ;
    } // convertXmlObjToArr

  /**
   * Return API version
   *
   * @param void
   * @return array
   */
  public function getVersion() {
    self::setRequestString('info');
    $response = self::callAPI();
    if (is_array($response)) {
      return $response;
    } // if
  } // getVersion

  /**
   * List all project
   *
   * @param void
   * @return array - array of ActiveCollabProject objects
   */
  public function listProjects() {
    $path_info = '/projects';
    self::setRequestString($path_info);
    $response = self::callAPI();
    if(is_array($response)) {
      return $response;
    } // if
  } // listProjects

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
