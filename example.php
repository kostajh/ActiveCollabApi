<?php
  
  // Include activeCollab API wrapper
  require_once dirname(__FILE__) . '/lib/include.php';
  
  // Authenticate
  ActiveCollab::setAPIUrl('http://localhost/corporate/public/api.php');
  ActiveCollab::setKey('4-EUASVXm3VgJXhUfIsN1uGRASO1i0gIiLrIsbuF5e');
  
  // List projects
  print '<pre>';
  
  $projects = ActiveCollab::listProjects();
  
  if($projects) {
    foreach($projects as $project) {
      print 'Project #' . $project->getId() . ': ' . htmlspecialchars($project->getName()) . '<br />';
    } // foreach
  } // if
  
  print '</pre>';

?>