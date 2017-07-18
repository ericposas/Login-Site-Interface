<?php
# if form was filled out correctly, connect to the database
$db = new mysqli('localhost', 'root', 'toor', 'test_db');
if($db->error){
  echo "ERROR: " . $db->errno . " - " . $db->error;
}
?>
