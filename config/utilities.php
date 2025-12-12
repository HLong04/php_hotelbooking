<?php
function view($view, $data = [])
{   
  $file = APPROOT . '\src\View' . '\\' . $view . '.php';
  // Check for view file

  if (is_readable($file))
  {
    
    if (isset($data['users'])) {
      $users = $data['users'];
    } else if (isset($data['user'])) {
      $user = $data['user'];
    } else {
      echo 'The key does not exist in the array.';
    }
    require_once $file;
  }
  else
  {
    // View does not exist
    die('<h1> 404 Page not found </h1>');
  }
}