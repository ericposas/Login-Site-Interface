<?php
# Check for loggin in user
if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION['authenticated_user'])){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet">
    <title>Logged in user page</title>
  </head>
  <body>
    <button id="back-to-index">Back to index page</button><br><br>
    <h3>You are logged in as authenticated user, <?php echo $_SESSION['authenticated_user']; ?>!</h3>
    <h3>Your e-mail is: <?php echo $_SESSION['email']; ?></h3>
    <script>
      document.getElementsByTagName('button')[0].addEventListener('click', function(e){
        window.open('index.php', '_self');
      });
    </script>
  </body>
</html>

<?php
}else{
  session_destroy();
  header("Location:index.php");
}
?>
