<?php
  
  $host = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "fiestaparfum_kp";
  
  $db = new mysqli($host, $user, $pass, $dbname);
  if ($db->connect_error) {
    die('Connect Error, '. $db->connect_errno . ': ' . $db->connect_error);
  }
  
?>