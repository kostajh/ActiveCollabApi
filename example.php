<?php

// Include activeCollab API wrapper
require_once dirname(__FILE__) . '/src/activeCollabAPI.php';

// Authenticate
$ac = new ActiveCollab();
$ac->setAPIUrl('');
$ac->setKey('');

// List projects
$projects = ActiveCollab::listProjects();

if($projects) {
  foreach($projects as $project) {
    print 'Project #' . $project->id . ': ' . htmlspecialchars($project->name) . "\n";
  }
}
