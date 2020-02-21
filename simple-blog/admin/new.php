<?php
require '../connection.php';

session_start();

if (!isset($_SESSION['user']) || empty($_SESSION)) {
    header('Location: /simple-blog/login.php');
}

$message = FALSE;

if ( isset( $_POST ) && !empty( $_POST ) ) {
    // Retrieve POSTed values.
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $description = $_POST['description'] ?? '';
    $date = strtotime( 'now' ); // Set to current time/date.

    // Set up SQL statement.
    $sql = 'INSERT INTO
        posts(title, content, description, date)
        VALUES("'.$title.'", "'.$content.'", "'.$description.'", '.$date.');';

    // Execute SQL statement.
    if ( $connection->query( $sql ) ) {
        $message = 'Successfully added your "'.$title.'" post to the database.';
        $_POST = array();
    } else {
        $message = 'Unable to add your "'.$title.'" post to the database. Please try again.';
        $message .= '<br><pre>'.print_r( $connection->error_list, TRUE ).'</pre>';
    }
}
?><!DOCTYPE html>
<html>
    <head>
        <title>
            New Post
        </title>
    </head>
    <body>
    <header>
      <?php include( '../nav.php' ); // nav ?>
    </header>
        <h1>New Post</h1>
        <?php if ( $message ) echo "<p>{$message}</p>"; // Show a message! ?>
        <form action="./new.php" method="POST">
            <label for="title">
                Title:
                <input type="text" name="title" placeholder="Enter a title..."<?php if ( isset( $_POST['title'] ) ) echo ' value="'.$_POST['title'].'"'; ?>>
            </label>
            <label for="content">
                Content:
                <textarea name="content" cols="30" rows="10" placeholder="Enter the blog post content..."><?php if ( isset( $_POST['content'] ) ) echo $_POST['content']; ?></textarea>
            </label>
            <label for="description">
                Description:
                <input type="text" name="description" placeholder="Enter a description..."<?php if ( isset( $_POST['description'] ) ) echo ' value="'.$_POST['description'].'"'; ?>>
            </label>
            <input type="submit" value="Add Post">
        </form>
    </body>
</html>
