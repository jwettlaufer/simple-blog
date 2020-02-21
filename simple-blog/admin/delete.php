<?php
require '../connection.php';

session_start();

if (!isset($_SESSION['user']) || empty($_SESSION)) {
    header('Location: /simple-blog/login.php');
}

$message = FALSE;

if ( isset( $_POST['id'] ) ) {
    $id = (integer) $_POST['id'];
    $sql = 'DELETE FROM posts WHERE id='.$id.';';
    if ( $connection->query( $sql ) ) {
        $message = 'Post successfully deleted.';
    } else {
        $message = 'Unable to delete target post.';
    }
}
?><!DOCTYPE html>
<html>
    <head>
        <title>Delete Post</title>
    </head>
    <body>
        <h1>Delete Post</h1>
        <?php if ( $message ) echo "<p>{$message}</p>"; // Show a message! ?>
        <a href="../index.php">
            Return to blog index.
        </a>
    </body>
</html>
