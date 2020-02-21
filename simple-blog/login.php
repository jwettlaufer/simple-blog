<?php
require './connection.php';

if ($connection->error) {
  echo 'Error encountered connecting to my DB. Please review:' . $connection->error;
 }


session_start();

 $password=$_POST['password'];

$_SESSION['user'] = $_POST['username'];


?><!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
  </head>
  <body>
    <h1>Login Page</h1>
    <form action="#" method="POST">
      <label for="username">
      <input type="text" placeholder="Enter your username..." name="username" value="<?php echo $_POST['username'] ?>">
      </label>
      <label for="passsword">
      <input type="password" placeholder="Enter your password..." name="password" value="<?php echo $_POST['passsword'] ?>">
      </label>
      <input type="submit" name="login" value="Login!">
    </form>
    <?php
    if (isset($_POST)) {

      $sql = "SELECT password
      FROM userInfo
      WHERE username = '" .$_POST['username']. "'";

        if ($result = $connection->query($sql)) {
          while ($row = $result->fetch_assoc()) {
            if(password_verify($password,$row['password'])){

              $_SESSION['logged_in'] = TRUE;
              header('Location: index.php');
            }
            else {echo 'Username and/or password are invalid. Please re-enter your credentials.';}
          }
        }
    }
    ?>
  </body>
</html>
