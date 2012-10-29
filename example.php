<?php

  // Include activeCollab API wrapper
  require_once dirname(__FILE__) . '/src/activeCollabAPI.php';

  // Authenticate
  ActiveCollab::setAPIUrl('');
  ActiveCollab::setKey('');

  // List projects
  print '<pre>';

  $projects = ActiveCollab::listProjects();

  if($projects) {
    foreach($projects as $project) {
      print 'Project #' . $project->id . ': ' . htmlspecialchars($project->name) . "\n";
    } // foreach
  } // if

  print '</pre>';

?>
