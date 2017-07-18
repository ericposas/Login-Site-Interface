<?php
# This script will test the logging-in feature/section
if(!isset($_SESSION)){
  session_start();
}
if(isset($_POST['login-submit'])){
  #echo '<h3 class="msg"></h3>';
  #echo '<h3 class="msg">Login attempt detected!</h3>';
  $_user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
  $_pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
  checkDatabaseForUser($_user, $_pass);
}

function checkDatabaseForUser($user, $pass){
  global $db;
  # write an SQL query to check the db for the user name
  $user_exists = false;
  $u = mysqli_real_escape_string($db, $user);
  $p = mysqli_real_escape_string($db, $pass);
  $sql = "SELECT `user` FROM users WHERE `user`='{$u}'";
  # prepare the query
  if(!($stmt = $db->prepare($sql))){
    echo "ERROR: ".$db->errno." - ".$db->error;
  }
  # execute the query
  if(!($stmt->execute())){
    echo "ERROR: ".$stmt->errno." - ".$stmt->error;
  }else{
    if(!($stmt->bind_result($_u))){
      echo "ERROR: ".$stmt->errno." - ".$stmt->error;
    }else{
      while($stmt->fetch()){
        if($_u){
          $user_exists = true;
        }
      }
    }
  }
  # if the user exists, continue by checking against the user's pass phrase
  if($user_exists == true){
    checkDatabaseForEmail($u);
    sleep(1);
    checkDatabaseForPass($u, $p);
  }else{
    # header("Refresh:0");
    echo '<h2 class="error"></h2><h2 class="error">Error: We have no record of that user.</h2>';
  }
}

function checkDatabaseForEmail($user){
  global $db;
  $sql = "SELECT `email` FROM users WHERE `user`='{$user}'";
  if(!($stmt = $db->prepare($sql))){
    echo "ERROR: ".$db->errno." - ".$db->error;
  }
  if(!($stmt->execute())){
    echo "ERROR: ".$stmt->errno." - ".$stmt->error;
  }else{
    if(!($stmt->bind_result($_e))){
      echo "ERROR: ".$stmt->errno." - ".$stmt->error;
    }else{
      while($stmt->fetch()){
        if($_e){
          $_SESSION['email'] = $_e;
        }
      }
    }
  }
}

function checkDatabaseForPass($user, $pass){
  global $db;
  # write an SQL query for checking the db for the user's corresponding hashed pass phrase
  $sql = "SELECT `hash` FROM users WHERE `user`='{$user}'";
  #prep the query
  if(!($stmt = $db->prepare($sql))){
    echo "ERROR: ".$db->errno." - ".$db->error;
  }
  # execute the query
  if(!($stmt->execute())){
    echo "ERROR: ".$stmt->errno." - ".$stmt->error;
  }else{
    if(!($stmt->bind_result($_hash))){
      echo "ERROR: ".$stmt->errno." - ".$stmt->error;
    }else{
      while($stmt->fetch()){
        if(password_verify($pass, $_hash)){
          $_SESSION['authenticated_user'] = $user;
          echo '<h2 class="msg"></h2><h2 class="msg">' . $user . ', you\'ve been logged in!</h2>';
          sleep(1);
          header("Location:auth.php");
        }else{
          session_destroy();
          echo '<h2 class="error"></h2><h2 class="error">Error: Wrong username/password combination!</h2>';
        }
      }
    }
  }
}

?>
