<?php
// Getting a safe input from the user
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//make life easier with defining __ROOT__
define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);

//add a config to the mix
require_once(dirname(__ROOT__).'/config_global.php');

//starting a session
session_start();
$connection = new mysqli($servername, $server_username, $server_password, $testdb);

 ?>
