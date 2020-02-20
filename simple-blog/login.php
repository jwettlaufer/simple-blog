<?php
session_start();
$username = 'red';
$password = '1234';

//Check for form submission.
if (isset($_POST)) {
  //Check if username and password is correct.
  if (($username === $_POST['username']) && ($password === $_POST['password'])) {
    //We are logged in.
    $_SESSION['logged_in'] = TRUE;
    header('Location: index.php');
  }
}

?><!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
  </head>
  <body>
    <h1>Login Page</h1>
    <form action="#" method="POST">
      <label for="username">
      <input type="text" placeholder="Enter your username..." name="username" value="<?php echo $_POST['password'] ?>">
      </label>
      <label for="passsword">
      <input type="password" placeholder="Enter your password..." name="password" value="<?php echo $_POST['password'] ?>">
      </label>
      <input type="submit" name="login" value="Login!">
    </form>
  </body>
</html>
