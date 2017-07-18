<?php
# check for $_POST variables
if(isset($_POST['register-submit'])){
  $_blank = FALSE;
  $_fail = FALSE;
  $_user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
  $_pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
  $_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $_form_info = array(
    'user' => $_user,
    'pass' => $_pass,
    'email' => $_email
  );
  foreach($_form_info as $entry=>$val){
    if(empty($_POST[$entry])){
      echo '<h3 class="error">Field ' . $entry . ' was not set.</h3>' . "\n";
      $_blank = TRUE;
    }
  }
  # validate e-mail address
  if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
    echo '<h3 class="error">Invalid e-mail address. Please correct it and re-submit.</h3>';
    $_fail = TRUE;
  }
  # check if any fields were left blank
  if($_blank == TRUE){
    echo '<h3 class="error">Please completely fill out the form.</h3>';
    $_fail = TRUE;
  }
}

if(isset($_fail) && $_fail == FALSE){
  # create new user, using the form data
  createNewUser($_user, $_pass, $_email);
}

?>
