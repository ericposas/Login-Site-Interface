<?php

function createNewUser($_user, $_pass, $_email){
  global $db;
  $user = mysqli_real_escape_string($db, $_user);
  $pass = mysqli_real_escape_string($db, $_pass);
  $email = mysqli_real_escape_string($db, $_email);
  $user_exists = false;
  # write an SQL queries
  $sql_select = "SELECT `user` FROM users WHERE `user`=?";
  # Prepare SQLs
  if(!($stmt_select = $db->prepare($sql_select))){
    echo "ERROR: " . $db->errno . " - " . $db->error;
  }
  # Check if user exists
  # Bind params for checking or SELECT query
  if(!($stmt_select->bind_param('s', $user))){
    echo "ERROR: " . $stmt_select->errno . " - " . $stmt_select->error;
  }
  if(!($stmt_select->execute())){
    echo "ERROR: " . $stmt_select->errno . " - " . $stmt_select->error;
  }else{
    if(!($stmt_select->bind_result($u))){
      echo "ERROR: " . $stmt_select->errno . " - " . $stmt_select->error;
    }else{
      while($stmt_select->fetch()){
        echo '<h3 class="error">User <span>'.$u.'</span> already exists.</h3>';
        echo '<h3 class="error">You have not been registered.</h3>';
        $user_exists = true;
      }
    }
  }

  # If user doesn't exist, then insert into the database
  if($user_exists == false){
    # Let's hash the password now, before inserting into the database
    if(!($hash = password_hash($pass, PASSWORD_BCRYPT))){
      echo "ERROR: Something went wrong when attempting to hash the password!";
    }
    # INSERT query
    $sql = "INSERT INTO users(`user`,`hash`,`email`) VALUES(?,?,?)";
    if(!($stmt = $db->prepare($sql))){
      echo "ERROR: " . $db->errno . " - " . $db->error;
    }
    # Bind params for INSERT command
    if(!($stmt->bind_param('sss', $user, $hash, $email))){
      echo "ERROR: " . $stmt->errno . " - " . $stmt->error;
    }
    # Execute SQL query
    if(!($stmt->execute())){
      echo "ERROR: ". $stmt->errno . " - " . $stmt->error;
    }else{
      echo '<h3 class="msg">New user <span>' . $user . '</span> added to the database.</h3>';
      echo '<h3 class="msg">You should now be able to log in and use the site as ' . $user . '.</h3>';
      $stmt->close();
    }
  }

}

?>
