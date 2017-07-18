<?php

# Testing Database interactions -- Basic login page, password hashing 

# First, unset any saved session variables from prev logins
session_start();
# log out if the user has pressed the 'log out' button
if(isset($_POST['log-out']) && isset($_SESSION['authenticated_user'])){
  unset($_SESSION['authenticated_user']);
  unset($_SESSION['email']);
  session_destroy();
}
# add in our dependencies
require_once 'connecttodatabase.php';
require_once 'createuser.php';
require_once 'register.php';
require_once 'login.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Database Testing</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet">
  </head>
  <body>
    <?php
      if(isset($_SESSION['authenticated_user'])){ ?>
        <div id="logged-in-area">
        <h3 id="logged-user">Logged in as: <?php echo $_SESSION['authenticated_user']; ?></h3>
        <form id="log-out-form" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
          <input id="log-out" type="submit" name="log-out" value="log out"></form>
        <button id="my-page">my page</button>
        </div>
        <script>
          document.getElementById('my-page').addEventListener('click', function(e){
            window.open('auth.php', '_self');
          });
        </script>
    <?php } ?>
    <!-- show the login or register buttons initially -->
    <div id="login-or-register">
      <h2 id="welcome">Welcome to the site!</h2>
      <button id="login-btn">Login</button><br><br>
      <div id="or">-OR-</div><br>
      <button id="register-btn">Register</button>
    </div>
    <!-- hide the login form area initially -->
    <div id="login">
      <h3>Login</h3>
      <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div>Username:</div>
        <input type="text" name="user" value=""><br><br>
        <div>Password:</div>
        <input type="password" name="pass" value=""><br><br>
        <input type="submit" name="login-submit" value="submit">
      </form>
    </div>
    <!-- hide the registration form area initially -->
    <div id="register">
      <h3>User registration form</h3><br>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>Username:</div>
        <input type="text" name="user" value=""><br><br>
        <div>Password:</div>
        <input type="password" name="pass" value=""><br><br>
        <div>E-mail address:</div>
        <input type="text" name="email" value=""><br><br>
        <input type="submit" name="register-submit" value="submit">
      </form>
    </div>
  </body>
</html>
